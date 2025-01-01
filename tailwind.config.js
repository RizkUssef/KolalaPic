/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/Views/**/*.{html,php}"],
  theme: {
    colors: {
      'bg': '#FFFDEC',
      "bg-dark":"1e1e1e",
      'primary': '#638C6D',
      'secondary': '#BAD8B6',
      'blur':'rgba(255, 253, 236,0.7)',
      'dark':'#638C6D',
      'dark-blur':'rgba(99, 140, 109,0.5)',
      'error':'#DE7C7D'
    },
    fontFamily: {
      lacquer: ["Lacquer", 'serif'],
    },
    extend: {
      dropShadow: {
        'main': '0 0 15px rgb(186, 216, 182) ',
        'input': '0 25px 25px rgba(186, 216, 182,0.5) ',
        'dark': '0 25px 25px rgba(255, 253, 236,0.5) ',
      },
     
    },
  },
  darkMode:"class",
  plugins: [],
}

