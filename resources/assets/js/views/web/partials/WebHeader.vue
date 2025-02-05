<template>
  <div class="iati-mobile-nav js-iati-mobile-nav">
    <div class="iati-mobile-nav__overlay js-iati-mobile-overlay"></div>
    <nav class="iati-mobile-nav__menu">
      <div class="iati-mobile-nav__header">
        <h2 class="iati-mobile-nav__label text-white">Menu</h2>
        <button
          class="iati-menu-toggle iati-menu-toggle--close js-iati-menu-toggle-close"
        >
          <span>Close</span>
        </button>
      </div>
      <ul class="">
        <li class="iati-mobile-nav__item">
          <a href="/" class="iati-mobile-nav__link">IATI Publisher</a>
        </li>
      </ul>
      <ul class="">
        <li class="iati-mobile-nav__item">
          <a
            href="https://iatistandard.org/en/about/"
            class="iati-mobile-nav__link"
            >About IATI</a
          >
        </li>
        <li class="iati-mobile-nav__item">
          <a
            href="https://iatistandard.org/en/using-data/"
            class="iati-mobile-nav__link"
            >Use Data</a
          >
        </li>
        <li class="iati-mobile-nav__item">
          <a
            href="https://iatistandard.org/en/guidance/publishing-data/"
            class="iati-mobile-nav__link"
          >
            Publish Data
          </a>
        </li>
        <li class="iati-mobile-nav__item">
          <a
            href="https://iatistandard.org/guidance/get-support/"
            class="iati-mobile-nav__link"
          >
            Contact
          </a>
        </li>
        <li class="iati-mobile-nav__item">
          <a href="#" class="iati-mobile-nav__link">Help Docs</a>
        </li>
      </ul>
    </nav>
  </div>

  <header class="iati-header">
    <div class="iati-header__section iati-header__section--first">
      <div class="iati-header__container">
        <a href="https://iatistandard.org/" aria-label="Go to IATI homepage">
          <img
            class="iati-header__logo"
            alt=""
            src="https://iati.github.io/design-system/assets/logo-colour-Bag5CeA4.svg"
          />
        </a>

        <nav class="iati-header__general-nav">
          <ul class="iati-piped-list">
            <li>
              <a href="https://iatistandard.org/en/about/">About IATI</a>
            </li>
            <li>
              <a href="https://iatistandard.org/en/using-data/">Use Data</a>
            </li>
            <li>
              <a href="https://iatistandard.org/en/guidance/publishing-data/">
                Publish Data
              </a>
            </li>
            <li>
              <a href="https://iatistandard.org/guidance/get-support/">
                Contact
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
    <div
      class="iati-header__section iati-header__section--last iati-brand-background"
    >
      <div class="iati-header__container iati-brand-background__content">
        <div class="iati-header__actions">
          <div class="iati-country-switcher">
            <label
              for="iati-country-switcher"
              class="iati-country-switcher__label"
              >Choose your language</label
            >
            <select
              id="iati-country-switcher"
              class="iati-country-switcher__control cursor-pointer"
            >
              <option>English</option>
              <option>French</option>
              <option>Spanish</option>
            </select>
          </div>

          <button
            class="iati-button iati-button--light hide--mobile-nav"
            @click="downloadManual('user')"
          >
            <span>Help Docs</span>
            <i class="iati-icon iati-icon--info"></i>
          </button>

          <button
            class="iati-menu-toggle iati-menu-toggle--open js-iati-menu-toggle-open"
          >
            <span class="iati-menu-toggle__label">Menu</span>
          </button>
        </div>

        <div class="iati-header-title">
          <p class="iati-header-title__eyebrow">IATI Tools</p>
          <p class="iati-header-title__heading">IATI Publisher</p>
        </div>

        <div class="iati-header__nav">
          <nav>
            <ul class="iati-tool-nav">
              <li><a href="/" class="iati-tool-nav-link">IATI Publisher</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </header>
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
