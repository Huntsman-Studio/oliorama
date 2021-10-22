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
      }
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
