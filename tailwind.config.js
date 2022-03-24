module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    fontFamily: {
      sans: ['Arial', 'sans-serif'],
    },
    colors: {
      black: '#000000',
      white: '#ffffff',
      transparent: 'transparent',
      n: {
        0: '#FFFFFF',
        10: '#F1F7F9',
        20: '#D5DCDE',
        30: '#A6B5BA',
        40: '#68797E',
        50: '#2A2F30',
      },
      paper: '#F6F7FC',
      rose: '#FFF1F0',
      mint: '#EEF9F5',
      eggshell: '#FFFDE7',
      crimson: '#06DBE4',
      lavender: '#06DBE4',
      salmon: '#06DBE4',
      spring: '#06DBE4',
      teal: '#F4B784',
      camel: '#F4B784',
      bluecoral: '#155366',
      turquoise: '#1FDFE7',
      lagoon: '#18ACB2',
    },
    extend: {
      fontSize: {
        'heading-1': '64px',
        'heading-2': '56px',
        'heading-3': '40px',
        'heading-4': '32px',
        'heading-5': '24px',
        tiny: '10px',
      },
    },
  },
  plugins: [],
};
