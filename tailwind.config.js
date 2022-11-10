// Function to add opacity to colors like default Tailwind's way when using CSS variables
function withOpacity(variableName) {
  return ({ opacityValue }) => {
    if (opacityValue !== undefined) {
      return `rgba(var(${variableName}), ${opacityValue})`;
    }
    return `rgb(var(${variableName}))`;
  };
}

module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.php',
    './resources/**/*.ts',
    './resources/**/*.vue',
    './config/*.php',
    './app/**/*.php',
  ],
  theme: {
    fontFamily: {
      sans: ['Arial', 'sans-serif'],
    },
    colors: {
      black: withOpacity('--black'),
      white: withOpacity('--white'),
      transparent: 'transparent',
      // Neutrals
      n: {
        0: withOpacity('--n-0'),
        10: withOpacity('--n-10'),
        20: withOpacity('--n-20'),
        30: withOpacity('--n-30'),
        40: withOpacity('--n-40'),
        50: withOpacity('--n-50'),
      },
      // Primary colors
      turquoise: withOpacity('--turquoise'),
      bluecoral: withOpacity('--bluecoral'),

      blue: {
        40: withOpacity('--bluecoral-40'),
        50: withOpacity('--bluecoral-50'),
      },
      // Secondary colors
      camel: {
        10: withOpacity('--camel-10'),
        20: withOpacity('--camel-20'),
        30: withOpacity('--camel-30'),
        40: withOpacity('--camel-40'),
        50: withOpacity('--camel-50'),
      },
      teal: {
        10: withOpacity('--teal-10'),
        20: withOpacity('--teal-20'),
        30: withOpacity('--teal-30'),
        40: withOpacity('--teal-40'),
        50: withOpacity('--teal-50'),
      },
      spring: {
        10: withOpacity('--spring-10'),
        20: withOpacity('--spring-20'),
        30: withOpacity('--spring-30'),
        40: withOpacity('--spring-40'),
        50: withOpacity('--spring-50'),
      },
      lagoon: {
        10: withOpacity('--lagoon-10'),
        20: withOpacity('--lagoon-20'),
        30: withOpacity('--lagoon-30'),
        40: withOpacity('--lagoon-40'),
        50: withOpacity('--lagoon-50'),
      },
      salmon: {
        10: withOpacity('--salmon-10'),
        20: withOpacity('--salmon-20'),
        30: withOpacity('--salmon-30'),
        40: withOpacity('--salmon-40'),
        50: withOpacity('--salmon-50'),
      },
      lavender: {
        10: withOpacity('--lavender-10'),
        20: withOpacity('--lavender-20'),
        30: withOpacity('--lavender-30'),
        40: withOpacity('--lavender-40'),
        50: withOpacity('--lavender-50'),
        60: withOpacity('--lavender-60'),
      },
      crimson: {
        10: withOpacity('--crimson-10'),
        20: withOpacity('--crimson-20'),
        30: withOpacity('--crimson-30'),
        40: withOpacity('--crimson-40'),
        50: withOpacity('--crimson-50'),
      },
      // Pastels
      eggshell: withOpacity('--eggshell'),
      mint: withOpacity('--mint'),
      rose: withOpacity('--rose'),
      paper: withOpacity('--paper'),
    },
    extend: {
      fontSize: {
        'heading-1': '64px',
        'heading-2': '56px',
        'heading-3': '40px',
        'heading-4': '32px',
        'heading-5': '24px',
        'caption-c1': '12px',
        tiny: '10px',
      },
      boxShadow: {
        dropdown: '0px 4px 40px rgba(0, 0, 0, 0.1)',
        default: '0px 2px 10px 10px rgba(0, 0, 0, 0.02)',
        textbox: '0px 8px 24px 20px rgba(42, 47, 48, 0.1)',
      
      },
    },
  },
  plugins: [],
};
