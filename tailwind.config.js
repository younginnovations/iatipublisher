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
      // Neutrals
      n: {
        0: '#FFFFFF',
        10: '#F1F7F9',
        20: '#D5DCDE',
        30: '#A6B5BA',
        40: '#68797E',
        50: '#2A2F30',
      },
      // Primary colors
      turquoise: '#06DBE4',
      bluecoral: '#155366',
      // Secondary colors
      camel: {
        10: '#FBE7D6',
        20: '#F9DBC1',
        30: '#F8CFAD',
        40: '#F6C398',
        50: '#F4B784',
      },
      teal: {
        10: '#E7F3F1',
        20: '#D7EBE8',
        30: '#C3E0DC',
        40: '#AFD6D1',
        50: '#87C2BA',
      },
      spring: {
        10: '#B2DDD3',
        20: '#8BCCBD',
        30: '#64BBA7',
        40: '#3EAA91',
        50: '#17997B',
      },
      lagoon: {
        10: '#D1EEF0',
        20: '#B2E3E5',
        30: '#8BD5D8',
        40: '#65C8CC',
        50: '#18ACB2',
      },
      salmon: {
        10: '#FFE3E0',
        20: '#FFD0CB',
        30: '#FFB8B1',
        40: '#FFA198',
        50: '#FF7264',
      },
      lavender: {
        10: '#EDE2FB',
        20: '#E1CFF8',
        30: '#D2B6F4',
        40: '#C49EF0',
        50: '#A66EE9',
      },
      crimson: {
        10: '#FFF8F7',
        20: '#FAD5D7',
        30: '#F19BA0',
        40: '#E34D5B',
        50: '#D1001E',
      },
      // Pastels
      eggshell: '#FFFDE7',
      mint: '#EEF9F5',
      rose: '#FFF1F0',
      paper: '#F6F7FC',
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
