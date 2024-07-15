/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
],
theme: {
    extend: {
      colors: {
        primary: {"50":"#eef2ff","100":"#e0e7ff","200":"#c7d2fe","300":"#a5b4fc","400":"#818cf8","500":"#6366f1","600":"#4f46e5","700":"#4338ca","800":"#3730a3","900":"#312e81","950":"#1e1b4b"}      },
    
    fontFamily: {
      'body': [
    'Inter', 
    'ui-sans-serif', 
    'system-ui', 
    '-apple-system', 
    'system-ui', 
    'Segoe UI', 
    'Roboto', 
    'Helvetica Neue', 
    'Arial', 
    'Noto Sans', 
    'sans-serif', 
    'Apple Color Emoji', 
    'Segoe UI Emoji', 
    'Segoe UI Symbol', 
    'Noto Color Emoji'
  ],
      'sans': [
    'Inter', 
    'ui-sans-serif', 
    'system-ui', 
    '-apple-system', 
    'system-ui', 
    'Segoe UI', 
    'Roboto', 
    'Helvetica Neue', 
    'Arial', 
    'Noto Sans', 
    'sans-serif', 
    'Apple Color Emoji', 
    'Segoe UI Emoji', 
    'Segoe UI Symbol', 
    'Noto Color Emoji'
  ]
    },
      width: {
        '1/2': '50%',     // 50%
        '1/3': '33.333333%', // 1/3
        '2/3': '66.666667%', // 2/3
        '1/4': '25%',     // 1/4
        '2/4': '50%',     // 2/4
        '3/4': '75%',     // 3/4
        '1/5': '20%',     // 1/5
        '2/5': '40%',     // 2/5
        '3/5': '60%',     // 3/5
        '4/5': '80%',     // 4/5
        '1/6': '16.666667%', // 1/6
        '2/6': '33.333333%', // 2/6
        '3/6': '50%',     // 3/6
        '4/6': '66.666667%', // 4/6
        '5/6': '83.333333%', // 5/6
        '1/12': '8.333333%', // 1/12
        '2/12': '16.666667%', // 2/12
        '3/12': '25%',    // 3/12
        '4/12': '33.333333%', // 4/12
        '5/12': '41.666667%', // 5/12
        '6/12': '50%',    // 6/12
        '7/12': '58.333333%', // 7/12
        '8/12': '66.666667%', // 8/12
        '9/12': '75%',    // 9/12
        '10/12': '83.333333%', // 10/12
        '11/12': '91.666667%', // 11/12
        'full': '100%',   // full width
        'screen': '100vw', // full viewport width
        '5': '1.25rem',         // 5 (20px)
        '10': '2.5rem',         // 10 (40px)
        '20': '5rem',           // 20 (80px)
        '30': '7.5rem',         // 30 (120px)
        '40': '10rem',         // 40 (160px)
        '50': '12.5rem',       // 50 (200px)
      },
      
      keyframes: {
        blink: {
          '0%': { opacity: 1 },
          '25%': { opacity: 0 },
          '50%': { opacity: 0 },
          '75%': { opacity: 0 },
          '100%': { opacity: 1 },
        }
      },
        animation: {
          blink: 'blink 1s linear infinite', // Apply the blink animation
        },
    },
},

plugins: [],
}