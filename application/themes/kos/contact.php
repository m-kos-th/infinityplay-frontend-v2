<?php
defined('C5_EXECUTE') or die('Access Denied.');
$this->inc('elements/header.php');
?>

<main id="main-content">
  <section class="contact" aria-labelledby="contact-title">
    <div class="contact__media" aria-hidden="true">
      <video class="contact__video" autoplay muted loop playsinline preload="metadata">
        <source src="video/shadow.mp4" type="video/mp4">
      </video>
    </div>

    <div class="contact__inner">
      <?php
      $contactInfoArea = new Area('Contact Info');
      $contactInfoArea->display($c);
      ?>

      <form class="contact__form" aria-labelledby="contact-form-title" method="post">
        <h2 class="contact__form-title" id="contact-form-title">Let's Talk</h2>
        <p class="contact__form-copy">
          Share your project details with us and let's create something amazing
          together.
        </p>

        <div class="contact__fields">
          <label class="contact__field">
            <span class="contact__label">Full name</span>
            <input class="contact__input" type="text" name="full_name" autocomplete="name" required>
          </label>

          <label class="contact__field">
            <span class="contact__label">Company name</span>
            <input class="contact__input" type="text" name="company_name" autocomplete="organization">
          </label>

          <div class="contact__field-grid">
            <label class="contact__field">
              <span class="contact__label">Email Address</span>
              <input class="contact__input" type="email" name="email" autocomplete="email" required>
            </label>

            <label class="contact__field">
              <span class="contact__label">Telephone</span>
              <input class="contact__input" type="tel" name="telephone" autocomplete="tel">
            </label>
          </div>

          <fieldset class="contact__services">
            <legend class="contact__label">What services are you interested in?</legend>
            <label class="contact__chip">
              <input class="contact__chip-input" type="checkbox" name="services" value="Games" checked>
              <span class="contact__chip-ui">
                <span class="contact__chip-icon" aria-hidden="true">
                  <svg viewBox="0 0 16 16" focusable="false">
                    <path d="M4.2 5.2h7.6a2 2 0 0 1 1.92 2.56l-.63 2.2a1.55 1.55 0 0 1-2.6.73L9.3 9.52H6.7L5.45 10.7a1.55 1.55 0 0 1-2.6-.73l-.63-2.2A2 2 0 0 1 4.2 5.2Z"/>
                    <path d="M5.8 7.1v2M4.8 8.1h2M10.8 7.4h.01M12 8.6h.01"/>
                  </svg>
                </span>
                <span class="contact__chip-text">Games</span>
              </span>
            </label>

            <label class="contact__chip">
              <input class="contact__chip-input" type="checkbox" name="services" value="2D">
              <span class="contact__chip-ui">
                <span class="contact__chip-icon" aria-hidden="true">
                  <svg viewBox="0 0 16 16" focusable="false">
                    <rect x="2.5" y="2.5" width="11" height="11" rx="2.5"/>
                    <path d="M5 11.2 11.5 4.8M8.1 4.8h3.4v3.4"/>
                  </svg>
                </span>
                <span class="contact__chip-text">2D</span>
              </span>
            </label>

            <label class="contact__chip">
              <input class="contact__chip-input" type="checkbox" name="services" value="3D">
              <span class="contact__chip-ui">
                <span class="contact__chip-icon contact__chip-icon--diamond" aria-hidden="true"></span>
                <span class="contact__chip-text">3D</span>
              </span>
            </label>

            <label class="contact__chip">
              <input class="contact__chip-input" type="checkbox" name="services" value="AI Cinematic">
              <span class="contact__chip-ui">
                <span class="contact__chip-icon" aria-hidden="true">
                  <svg viewBox="0 0 16 16" focusable="false">
                    <circle cx="8" cy="8" r="5.25"/>
                    <path d="M8 5.1v2.2l1.9 1.1M5.1 8h.01M10.9 8h.01M8 10.9h.01"/>
                  </svg>
                </span>
                <span class="contact__chip-text">AI Cinematic</span>
              </span>
            </label>

            <label class="contact__chip">
              <input class="contact__chip-input" type="checkbox" name="services" value="Roblox">
              <span class="contact__chip-ui">
                <span class="contact__chip-icon" aria-hidden="true">
                  <svg viewBox="0 0 16 16" focusable="false">
                    <path d="M4.4 2.8 13 4.7 11.1 13.2 2.6 11.4 4.4 2.8Z"/>
                    <path d="m7 6.3 2.2.5-.5 2.2-2.2-.5.5-2.2Z"/>
                  </svg>
                </span>
                <span class="contact__chip-text">Roblox</span>
              </span>
            </label>

            <label class="contact__chip">
              <input class="contact__chip-input" type="checkbox" name="services" value="Other">
              <span class="contact__chip-ui">
                <span class="contact__chip-icon" aria-hidden="true">
                  <svg viewBox="0 0 16 16" focusable="false">
                    <path d="M4 4.2h3.1v3.1H4zM8.9 4.2H12v3.1H8.9zM4 8.9h3.1V12H4zM8.9 8.9H12V12H8.9z"/>
                  </svg>
                </span>
                <span class="contact__chip-text">Other</span>
              </span>
            </label>
          </fieldset>

          <label class="contact__field">
            <span class="contact__label">Budget range</span>
            <span class="contact__select-wrap">
              <span class="contact__select-icon" aria-hidden="true">
                <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M8.33333 16.6667C3.73083 16.6667 0 12.9358 0 8.33333C0 3.73083 3.73083 0 8.33333 0C12.9358 0 16.6667 3.73083 16.6667 8.33333C16.6667 12.9358 12.9358 16.6667 8.33333 16.6667ZM8.33333 15C10.1014 15 11.7971 14.2976 13.0474 13.0474C14.2976 11.7971 15 10.1014 15 8.33333C15 6.56522 14.2976 4.86953 13.0474 3.61929C11.7971 2.36905 10.1014 1.66667 8.33333 1.66667C6.56522 1.66667 4.86953 2.36905 3.61929 3.61929C2.36905 4.86953 1.66667 6.56522 1.66667 8.33333C1.66667 10.1014 2.36905 11.7971 3.61929 13.0474C4.86953 14.2976 6.56522 15 8.33333 15ZM7.5 11.6667H5V5H7.5V3.33333H9.16667V5H10C10.3869 5 10.7662 5.10774 11.0953 5.31114C11.4244 5.51455 11.6904 5.80558 11.8634 6.15164C12.0364 6.49769 12.1097 6.88509 12.0749 7.27043C12.0402 7.65576 11.8988 8.02381 11.6667 8.33333C11.8988 8.64285 12.0402 9.0109 12.0749 9.39624C12.1097 9.78157 12.0364 10.169 11.8634 10.515C11.6904 10.8611 11.4244 11.1521 11.0953 11.3555C10.7662 11.5589 10.3869 11.6667 10 11.6667H9.16667V13.3333H7.5V11.6667ZM6.66667 9.16667V10H10C10.1105 10 10.2165 9.9561 10.2946 9.87796C10.3728 9.79982 10.4167 9.69384 10.4167 9.58333C10.4167 9.47283 10.3728 9.36685 10.2946 9.2887C10.2165 9.21056 10.1105 9.16667 10 9.16667H6.66667ZM6.66667 6.66667V7.5H10C10.1105 7.5 10.2165 7.4561 10.2946 7.37796C10.3728 7.29982 10.4167 7.19384 10.4167 7.08333C10.4167 6.97283 10.3728 6.86685 10.2946 6.7887C10.2165 6.71056 10.1105 6.66667 10 6.66667H6.66667Z" fill="white" fill-opacity="0.6"/>
                </svg>
              </span>
              <select class="contact__input contact__select" name="budget">
                <option value="" selected>-Select budget range-</option>
                <option value="under-10000">Under $10,000</option>
                <option value="10000-50000">$10,000 - $50,000</option>
                <option value="50000-100000">$50,000 - $100,000</option>
                <option value="100000-plus">$100,000+</option>
              </select>
              <span class="contact__select-arrow" aria-hidden="true">
                <svg viewBox="0 0 12 12" focusable="false">
                  <path d="m2.5 4.5 3.5 3.5 3.5-3.5"/>
                </svg>
              </span>
            </span>
          </label>

          <label class="contact__field contact__field--textarea">
            <span class="contact__label">Share a brief project description (optional)</span>
            <textarea class="contact__input contact__textarea" name="description"></textarea>
          </label>

          <label class="contact__field contact__field--hidden" aria-hidden="true">
            <span class="contact__label">Website</span>
            <input class="contact__input" type="text" name="website" tabindex="-1" autocomplete="off">
          </label>
        </div>

        <label class="contact__agree">
          <input class="contact__agree-input" type="checkbox" name="agree" required>
          <span class="contact__agree-box" aria-hidden="true"></span>
          <span class="contact__agree-text">I agree to the terms of service and privacy policy</span>
        </label>

        <button class="contact__submit" type="submit" data-default-label="Send">
          <svg class="contact__submit-cap contact__submit-cap--left" width="17" height="38" viewBox="0 0 17 38" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M0 9.65686C0 8.59599 0.421427 7.57857 1.17157 6.82843L6.82843 1.17157C7.57857 0.421426 8.59599 0 9.65685 0L17 0V38H9.65685C8.59599 38 7.57857 37.5786 6.82843 36.8284L1.17157 31.1716C0.421426 30.4214 0 29.404 0 28.3431V9.65686Z" fill="#ECEAE5"/>
          </svg>
          <span class="contact__submit-label">Send</span>
          <svg class="contact__submit-cap contact__submit-cap--right" width="17" height="38" viewBox="0 0 17 38" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M17 9.65686C17 8.59599 16.5786 7.57857 15.8284 6.82843L10.1716 1.17157C9.42143 0.421426 8.40401 0 7.34315 0L0 0V38H7.34315C8.40401 38 9.42143 37.5786 10.1716 36.8284L15.8284 31.1716C16.5786 30.4214 17 29.404 17 28.3431V9.65686Z" fill="#ECEAE5"/>
          </svg>
        </button>
        <p class="contact__status" role="status" aria-live="polite"></p>
      </form>
    </div>

    <div class="contact__marquee" aria-hidden="true" id="marquee-contact">
      INFINITY PLAY&nbsp;&nbsp;&nbsp;INFINITY PLAY&nbsp;&nbsp;&nbsp;INFINITY PLAY&nbsp;&nbsp;&nbsp;INFINITY PLAY&nbsp;&nbsp;&nbsp;INFINITY PLAY&nbsp;&nbsp;&nbsp;INFINITY PLAY&nbsp;&nbsp;&nbsp;
    </div>
  </section>
</main>

<?php $this->inc('elements/footer.php'); ?>
