/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php",
    "./**/*.php",
    "./assets/js/**/*.js"
  ],
  theme: {
    extend: {
      colors: {
        midnight: {
          950: '#020817',
          925: '#030d1d',
          900: '#050f24',
          850: '#071431',
          800: '#0a1b3a',
          700: '#102347',
          600: '#1a2f58'
        },
        accent: {
          300: '#93c5fd',
          400: '#60a5fa',
          500: '#3b82f6',
          600: '#2563eb'
        }
      },
      fontFamily: {
        sans: ['Inter', 'Poppins', 'sans-serif'],
        display: ['Poppins', 'Inter', 'sans-serif']
      },
      boxShadow: {
        primary: '0 30px 120px rgba(8, 16, 36, 0.48)',
        frosted: '0 32px 90px rgba(5, 12, 28, 0.65)'
      },
      maxWidth: {
        '8xl': '90rem'
      }
    }
  },
  plugins: [require('@tailwindcss/typography')]
};
