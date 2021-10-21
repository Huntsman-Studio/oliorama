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
        'primary': '#0C0C0C',
        'secondary': '#4C4C4C',
        'danger': '#191919',
      }),

      // text color
      textColor: theme => theme('colors'),
      textColor: {
        'gray1': '#B2B2B2',
        'secondary': '#ffed4a',
        'danger': '#e3342f',
      }
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
