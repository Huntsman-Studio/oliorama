module.exports = {
  purge: [
    // Paths to your templates...
    "../**.php",
    "../**/**.php",
    "./src/js/**.js"
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      // background color
      backgroundColor: theme => ({
        ...theme('colors'),
        'davys-gray': '#0C0C0C',
        'gray-wolf': '#191919',
        'dark-gray': '#333333',
        'carbon-gray': '#4C4C4C',
        'dim-gray': '#666666',
        'gray-goose': '#7f7f7f',
        'gray-cloud': '#b2b2b2',
        'gainsboro': '#cccccc',
        'light-gray': '#e5e5e5',
        'fire': '#ffbc21',
        'gold': '#ffd21d',
        'candy': '#f71c31',
        'mint': '#1cce9f'
      }),

      // text color
      textColor: theme => theme('colors'),
      textColor: {
        'davys-gray': '#0C0C0C',
        'gray-wolf': '#191919',
        'dark-gray': '#333333',
        'carbon-gray': '#4C4C4C',
        'dim-gray': '#666666',
        'gray-goose': '#7f7f7f',
        'gray-cloud': '#b2b2b2',
        'gainsboro': '#cccccc',
        'light-gray': '#e5e5e5',
        'fire': '#ffbc21',
        'gold': '#ffd21d',
        'candy': '#f71c31',
        'mint': '#1cce9f'
      },

      // border color
      borderColor: theme => ({
        ...theme('colors'),
        'davys-gray': '#0C0C0C',
        'gray-wolf': '#191919',
        'dark-gray': '#333333',
        'carbon-gray': '#4C4C4C',
        'dim-gray': '#666666',
        'gray-goose': '#7f7f7f',
        'gray-cloud': '#b2b2b2',
        'gainsboro': '#cccccc',
        'light-gray': '#e5e5e5',
        'fire': '#ffbc21',
        'gold': '#ffd21d',
        'candy': '#f71c31',
        'mint': '#1cce9f'
      }),

      // backgorund image
      backgroundImage: {
        // 'homepagehoney': 'url("http://oliorama.com/wp-content/uploads/2022/01/Homepagehoney.png")',
        'home-rewards': "url('http://oliorama.com/wp-content/uploads/2022/01/home-page-awards.jpg')",
        'home-rewards-mb': "()",
        'home-olive-oil': 'url("http://oliorama.com/wp-content/uploads/2022/01/Homepageoliveoil.png")',
        'home-honey': 'url("http://oliorama.com/wp-content/uploads/2022/01/Homepagehoney.png")',
        'home-herbs': 'url("http://oliorama.com/wp-content/uploads/2022/01/Homepageherbs.png")',
        'home-gifts': 'url("http://oliorama.com/wp-content/uploads/2022/01/home-page-gift.jpg")'
        // 'footer-texture': "url('/img/footer-texture.png')",
      }
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
