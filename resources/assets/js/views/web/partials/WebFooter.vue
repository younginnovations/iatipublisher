<template>
  <footer class="iati-footer iati-brand-background mt-14">
    <div class="iati-brand-background__content">
      <div class="iati-footer__section iati-footer__section--first">
        <div class="iati-footer__container">
          <div class="iati-footer-block">
            <h2 class="iati-footer-block__title text-white">Useful Links</h2>
            <div class="iati-footer-block__content">
              <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/about">About</a></li>
                <li><a href="/">Sign In</a></li>
                <li><a href="/register/join">Join Now</a></li>
                <li>
                  <a
                    rel="noopener noreferrer"
                    class="cursor-pointer"
                    @click="downloadManual('user')"
                    >User Manual v1.1</a
                  >
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="iati-footer__section">
        <div class="iati-footer__container">
          <div class="iati-footer-block">
            <h2 class="iati-footer-block__title text-white">
              Additional Information
            </h2>
            <div
              class="iati-footer-block__content iati-footer-block__content--columns"
            >
              <div>
                <p>Part of the IATI Unified Platform.</p>
                <p>
                  Code licensed under
                  <a href="https://www.gnu.org/licenses/agpl-3.0.en.html"
                    >GNU AGPL</a
                  >.
                </p>
                <p>
                  Documentation licensed under
                  <a href="https://creativecommons.org/licenses/by/4.0/"
                    >CC BY 3.0</a
                  >.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="iati-footer__section iati-footer__section--last">
        <div class="iati-footer__container">
          <nav>
            <ul class="iati-piped-list iati-footer__legal-nav">
              <li>
                <a href="https://iatistandard.org/en/privacy-policy/"
                  >Privacy</a
                >
              </li>
              <li>
                <a href="https://iatistandard.org/en/data-removal/"
                  >Data removal</a
                >
              </li>
              <li><span>© Copyright IATI 2024</span></li>
            </ul>
          </nav>

          <div class="iati-country-switcher">
            <label
              for="iati-country-switcher"
              class="iati-country-switcher__label"
              >Choose your language</label
            >
            <select
              id="iati-country-switcher"
              class="iati-country-switcher__control"
            >
              <option>English</option>
              <option>French</option>
            </select>
          </div>

          <div class="iati-footer__social">
            <a
              href="https://www.linkedin.com/company/international-aid-transparency-initiative/"
              aria-label="LinkedIn"
            >
              <i class="iati-icon iati-icon--linkedin"></i>
            </a>
            <a href="https://x.com/IATI_aid" aria-label="X">
              <i class="iati-icon iati-icon--x"></i>
            </a>
            <a
              href="https://www.youtube.com/channel/UCAVH1gcgJXElsj8ENC-bDQQ"
              aria-label="YouTube"
            >
              <i class="iati-icon iati-icon--youtube"></i>
            </a>
            <a href="https://www.facebook.com/IATIaid/" aria-label="Facebook">
              <i class="iati-icon iati-icon--facebook"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup lang="ts">
import axios from 'axios';

function downloadManual(type: string) {
  let fileName = {
    user: 'IATI_Publisher-User_Manual_v1.1.pdf',
  };
  let url = window.location.origin + `/Data/Manuals/${fileName[type]}`;

  axios({
    url: url,
    method: 'GET',
    responseType: 'arraybuffer',
  }).then((response) => {
    let blob = new Blob([response.data], {
      type: 'application/pdf',
    });
    let link = document.createElement('a');
    link.href = window.URL.createObjectURL(blob);
    link.download = fileName[type];
    link.click();
  });
}
</script>
