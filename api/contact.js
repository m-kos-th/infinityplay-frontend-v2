const RESEND_API_URL = 'https://api.resend.com/emails';
const MAX_FIELD_LENGTH = 2000;

function safeParseBody(body) {
  if (!body) return {};
  if (typeof body === 'object') return body;

  try {
    return JSON.parse(body);
  } catch {
    return {};
  }
}

function normalizeField(value, maxLength = MAX_FIELD_LENGTH) {
  return String(value || '').trim().slice(0, maxLength);
}

function normalizeServices(value) {
  if (Array.isArray(value)) {
    return value.map((item) => normalizeField(item, 80)).filter(Boolean);
  }

  const single = normalizeField(value, 80);
  return single ? [single] : [];
}

function escapeHtml(value) {
  return String(value)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#39;');
}

module.exports = async (req, res) => {
  if (req.method !== 'POST') {
    res.setHeader('Allow', 'POST');
    return res.status(405).json({ error: 'Method not allowed.' });
  }

  const apiKey = process.env.RESEND_API_KEY;

  if (!apiKey) {
    return res.status(500).json({ error: 'Email service is not configured.' });
  }

  const body = safeParseBody(req.body);
  const fullName = normalizeField(body.full_name, 120);
  const companyName = normalizeField(body.company_name, 120);
  const email = normalizeField(body.email, 160);
  const telephone = normalizeField(body.telephone, 80);
  const budget = normalizeField(body.budget, 80);
  const description = normalizeField(body.description, 4000);
  const website = normalizeField(body.website, 160);
  const services = normalizeServices(body.services);
  const agree = Boolean(body.agree);

  if (website) {
    return res.status(200).json({ ok: true });
  }

  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  if (!fullName || !emailPattern.test(email)) {
    return res.status(400).json({ error: 'A valid name and email address are required.' });
  }

  if (!agree) {
    return res.status(400).json({ error: 'Terms acceptance is required.' });
  }

  const to = process.env.CONTACT_TO_EMAIL || 'info@infinityplay.com';
  const from = process.env.RESEND_FROM_EMAIL || 'Infinity Play <onboarding@resend.dev>';
  const servicesLabel = services.length ? services.join(', ') : 'Not specified';
  const budgetLabel = budget || 'Not specified';
  const companyLabel = companyName || 'Not provided';
  const telephoneLabel = telephone || 'Not provided';
  const descriptionLabel = description || 'No project description provided.';

  const subject = `New contact form enquiry from ${fullName}`;
  const html = `
    <div style="font-family:Arial,sans-serif;line-height:1.6;color:#111827">
      <h1 style="font-size:20px;margin-bottom:16px;">New contact form enquiry</h1>
      <p><strong>Name:</strong> ${escapeHtml(fullName)}</p>
      <p><strong>Company:</strong> ${escapeHtml(companyLabel)}</p>
      <p><strong>Email:</strong> ${escapeHtml(email)}</p>
      <p><strong>Telephone:</strong> ${escapeHtml(telephoneLabel)}</p>
      <p><strong>Services:</strong> ${escapeHtml(servicesLabel)}</p>
      <p><strong>Budget:</strong> ${escapeHtml(budgetLabel)}</p>
      <p><strong>Description:</strong></p>
      <p>${escapeHtml(descriptionLabel).replace(/\n/g, '<br>')}</p>
    </div>
  `;

  const text = [
    'New contact form enquiry',
    `Name: ${fullName}`,
    `Company: ${companyLabel}`,
    `Email: ${email}`,
    `Telephone: ${telephoneLabel}`,
    `Services: ${servicesLabel}`,
    `Budget: ${budgetLabel}`,
    'Description:',
    descriptionLabel,
  ].join('\n');

  try {
    const resendResponse = await fetch(RESEND_API_URL, {
      method: 'POST',
      headers: {
        Authorization: `Bearer ${apiKey}`,
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        from,
        to: [to],
        reply_to: email,
        subject,
        html,
        text,
      }),
    });

    const resendResult = await resendResponse.json().catch(() => ({}));

    if (!resendResponse.ok) {
      return res.status(502).json({
        error: resendResult.message || 'Resend could not deliver this message.',
      });
    }

    return res.status(200).json({
      ok: true,
      id: resendResult.id || null,
    });
  } catch {
    return res.status(502).json({ error: 'Unable to reach the email service right now.' });
  }
};
