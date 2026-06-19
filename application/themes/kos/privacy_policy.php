<?php
defined('C5_EXECUTE') or die('Access Denied.');
require_once __DIR__ . '/elements/function.php';

$pageTitle = 'Privacy Policy | Infinity Play';
$pageDescription = 'Privacy Policy for Infinity Play — how we collect, use, disclose, and protect information provided by clients who engage us for game development and related professional services.';
$shareTitle = $pageTitle;
$shareDescription = 'How Infinity Play collects, uses, discloses, and protects client information.';
$canonicalUrl = kos_absolute_url(kos_privacy_url());
$this->inc('elements/header.php');
?>

<main class="policy" id="main-content">

  <!-- Glowing pill badge — the page title -->
  <div class="policy__badge-wrap">
    <span class="policy__badge">
      <span class="policy__badge-text">Privacy Policy</span>
    </span>
    <span class="policy__sparkles" aria-hidden="true"></span>
  </div>

  <p class="policy__lead">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type</p>

  <section class="policy__section">
    <h2 class="policy__section-title">Effective as of: December 22, 2025</h2>
    <p>Infinity Play respects the privacy of our business clients and partners. This Privacy Policy explains how we collect, use, disclose, and protect information provided by clients who engage Infinity Play for game development and related professional services.</p>
  </section>

  <section class="policy__section">
    <h2 class="policy__section-title">Policy Scope</h2>
    <p>This policy applies to information collected from clients, representatives, and partners in connection with game development projects, consulting services, and business communications.</p>
  </section>

  <section class="policy__section">
    <h2 class="policy__section-title">Client Information We Collect</h2>
    <p>We may collect business and personal contact information provided during project discussions and service agreements. This may include names, company details, job titles, email addresses, phone numbers, billing information, and project-related materials.</p>
  </section>

  <section class="policy__section">
    <h2 class="policy__section-title">Use of Client Information</h2>
    <p>Client information is used to manage projects, communicate progress, deliver services, process payments, prepare documentation, and maintain business relationships.</p>
  </section>

  <section class="policy__section">
    <h2 class="policy__section-title">Information Sharing</h2>
    <p>Infinity Play does not sell or share client information with third parties for marketing purposes.</p>
    <p>Information may be shared with trusted partners or subcontractors only when necessary to complete a project and under confidentiality obligations.</p>
  </section>

  <section class="policy__section">
    <h2 class="policy__section-title">Data Sharing</h2>
    <p>Infinity Play does not sell or rent personal information to third parties.</p>
    <p>Information may be shared with trusted partners or subcontractors only when necessary to complete a project and under confidentiality obligations.</p>
  </section>

  <section class="policy__section">
    <h2 class="policy__section-title">Data Security Measures</h2>
    <p>We implement appropriate administrative, technical, and physical safeguards to protect client information and project data from unauthorized access or disclosure.</p>
  </section>

  <section class="policy__section">
    <h2 class="policy__section-title">Data Retention</h2>
    <p>Client information is retained for the duration of the project and as necessary for legal, contractual, and business record purposes.</p>
  </section>

  <section class="policy__section">
    <h2 class="policy__section-title">Policy Updates</h2>
    <p>Infinity Play may update this Privacy Policy as business practices or legal requirements change. Updates will become effective once published or communicated to clients.</p>
  </section>

</main>

<?php $this->inc('elements/footer.php'); ?>
