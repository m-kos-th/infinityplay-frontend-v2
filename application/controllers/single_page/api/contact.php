<?php

namespace Application\Controller\SinglePage\Api;

use Concrete\Core\Page\Controller\PageController;
use Symfony\Component\HttpFoundation\JsonResponse;

class Contact extends PageController
{
    private const RESEND_API_URL = 'https://api.resend.com/emails';
    private const MAX_FIELD_LENGTH = 2000;

    public function on_start(): void
    {
        $response = $this->handleRequest();
        $response->send();
        exit;
    }

    private function handleRequest(): JsonResponse
    {
        if (!$this->request->isMethod('POST')) {
            return new JsonResponse(['error' => 'Method not allowed.'], 405, ['Allow' => 'POST']);
        }

        $apiKey = $this->env('RESEND_API_KEY');
        if ($apiKey === '') {
            return new JsonResponse(['error' => 'Email service is not configured.'], 500);
        }

        $body = $this->parseBody((string) $this->request->getContent());
        $fullName = $this->normalizeField($body['full_name'] ?? '', 120);
        $companyName = $this->normalizeField($body['company_name'] ?? '', 120);
        $email = $this->normalizeField($body['email'] ?? '', 160);
        $telephone = $this->normalizeField($body['telephone'] ?? '', 80);
        $budget = $this->normalizeField($body['budget'] ?? '', 80);
        $description = $this->normalizeField($body['description'] ?? '', 4000);
        $website = $this->normalizeField($body['website'] ?? '', 160);
        $services = $this->normalizeServices($body['services'] ?? []);
        $agree = $this->truthy($body['agree'] ?? false);

        if ($website !== '') {
            return new JsonResponse(['ok' => true], 200);
        }

        if ($fullName === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return new JsonResponse(['error' => 'A valid name and email address are required.'], 400);
        }

        if (!$agree) {
            return new JsonResponse(['error' => 'Terms acceptance is required.'], 400);
        }

        $to = $this->env('CONTACT_TO_EMAIL', 'info@infinityplay.com');
        $from = $this->env('RESEND_FROM_EMAIL', 'Infinity Play <onboarding@resend.dev>');
        $servicesLabel = count($services) ? implode(', ', $services) : 'Not specified';
        $budgetLabel = $budget !== '' ? $budget : 'Not specified';
        $companyLabel = $companyName !== '' ? $companyName : 'Not provided';
        $telephoneLabel = $telephone !== '' ? $telephone : 'Not provided';
        $descriptionLabel = $description !== '' ? $description : 'No project description provided.';
        $subject = 'New contact form enquiry from ' . $fullName;

        $html = sprintf(
            '<div style="font-family:Arial,sans-serif;line-height:1.6;color:#111827"><h1 style="font-size:20px;margin-bottom:16px;">New contact form enquiry</h1><p><strong>Name:</strong> %s</p><p><strong>Company:</strong> %s</p><p><strong>Email:</strong> %s</p><p><strong>Telephone:</strong> %s</p><p><strong>Services:</strong> %s</p><p><strong>Budget:</strong> %s</p><p><strong>Description:</strong></p><p>%s</p></div>',
            $this->escapeHtml($fullName),
            $this->escapeHtml($companyLabel),
            $this->escapeHtml($email),
            $this->escapeHtml($telephoneLabel),
            $this->escapeHtml($servicesLabel),
            $this->escapeHtml($budgetLabel),
            nl2br($this->escapeHtml($descriptionLabel), false)
        );

        $text = implode("\n", [
            'New contact form enquiry',
            'Name: ' . $fullName,
            'Company: ' . $companyLabel,
            'Email: ' . $email,
            'Telephone: ' . $telephoneLabel,
            'Services: ' . $servicesLabel,
            'Budget: ' . $budgetLabel,
            'Description:',
            $descriptionLabel,
        ]);

        [$statusCode, $result] = $this->sendResend($apiKey, [
            'from' => $from,
            'to' => [$to],
            'reply_to' => $email,
            'subject' => $subject,
            'html' => $html,
            'text' => $text,
        ]);

        if ($statusCode < 200 || $statusCode >= 300) {
            return new JsonResponse([
                'error' => $result['message'] ?? 'Resend could not deliver this message.',
            ], 502);
        }

        return new JsonResponse([
            'ok' => true,
            'id' => $result['id'] ?? null,
        ], 200);
    }

    private function parseBody(string $content): array
    {
        if ($content === '') {
            return [];
        }

        $decoded = json_decode($content, true);

        return is_array($decoded) ? $decoded : [];
    }

    private function normalizeField($value, int $maxLength = self::MAX_FIELD_LENGTH): string
    {
        return substr(trim((string) $value), 0, $maxLength);
    }

    private function normalizeServices($value): array
    {
        if (!is_array($value)) {
            $single = $this->normalizeField($value, 80);

            return $single !== '' ? [$single] : [];
        }

        $services = [];
        foreach ($value as $item) {
            $normalized = $this->normalizeField($item, 80);
            if ($normalized !== '') {
                $services[] = $normalized;
            }
        }

        return $services;
    }

    private function truthy($value): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        return in_array(strtolower((string) $value), ['1', 'true', 'yes', 'on'], true);
    }

    private function env(string $key, string $default = ''): string
    {
        $value = getenv($key);
        if ($value === false || $value === '') {
            $value = $_ENV[$key] ?? $_SERVER[$key] ?? $default;
        }

        return is_string($value) ? trim($value, " \t\n\r\0\x0B\"'") : $default;
    }

    private function escapeHtml(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    private function sendResend(string $apiKey, array $payload): array
    {
        if (function_exists('curl_init')) {
            $ch = curl_init(self::RESEND_API_URL);
            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $apiKey,
                    'Content-Type: application/json',
                ],
                CURLOPT_POSTFIELDS => json_encode($payload),
            ]);

            $responseBody = curl_exec($ch);
            $statusCode = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
            curl_close($ch);

            $result = json_decode((string) $responseBody, true);

            return [$statusCode, is_array($result) ? $result : []];
        }

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Authorization: Bearer {$apiKey}\r\nContent-Type: application/json\r\n",
                'content' => json_encode($payload),
                'ignore_errors' => true,
            ],
        ]);

        $responseBody = @file_get_contents(self::RESEND_API_URL, false, $context);
        $statusCode = 0;

        if (isset($http_response_header[0]) && preg_match('/\s(\d{3})\s/', $http_response_header[0], $matches)) {
            $statusCode = (int) $matches[1];
        }

        $result = json_decode((string) $responseBody, true);

        return [$statusCode, is_array($result) ? $result : []];
    }
}
