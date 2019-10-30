<template>
  <v-footer
    dark
    padless
  >
    <v-card
      flat
      tile
      class="indigo lighten-1 white--text text-center"
      style="width:100%"
    >
      <v-card-text>
        <v-btn
          v-for="item in icons"
          :key="item.icon"
          class="mx-4 white--text"
          icon
          :href="item.link"
          target="_blank"
        >
          <v-icon size="24px">{{ item.icon }}</v-icon>
        </v-btn>
      </v-card-text>
      <v-row
        justify="center"
        no-gutters >
        <v-btn
          v-for="link in links"
          :key="link.title"
          color="white"
          text
          rounded
          class="my-2" 
          :href="link.link">
          {{ link.title }}
        </v-btn>
      </v-row>
      <v-divider></v-divider>

      <v-card-text class="white--text pt-0">
        Here's the company's description.
        Here's the company's description.
        Here's the company's description.
      </v-card-text>

      <v-divider></v-divider>

      <v-card-text class="white--text">
        {{ new Date().getFullYear() }} — <strong>{{company}}</strong>
      </v-card-text>
    </v-card>
  </v-footer>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import { faFacebook, faTwitter, faLinkedin, faInstagram, faWeibo, faWeixin, faGooglePlay } from '@fortawesome/fontawesome-free-brands'

export default {
  data: () => ({
    icons: [
      {icon: 'fa-facebook', link: 'https://facebook.com' },
      {icon: 'fa-twitter', link: 'https://twitter.com' },
      {icon: 'fa-linkedin', link: 'https://linkedin.com' },
      {icon: 'fa-instagram', link: 'https://instagram.com' },
    ],
    links: [
      {title: 'Home', link: '/' },
      {title: 'About Us', link: '/about-us' },
      {title: 'Team', link: '/team' },
      {title: 'Services', link: '/services' },
      {title: 'Privacy', link: '/privacy' },
      {title: 'Blog', link: '/blog' },
      {title: 'Contact Us', link: '/contact-us' }
    ],
    company: "Baicy Tech"
  })
}
</script>