 // tailwind.config.js
 const flowbite = require('flowbite/plugin');
 const forms = require('@tailwindcss/forms');

 
 module.exports = {
     darkMode: 'false',
   content: [
    "./Views/**/*.php",         // ✅ all PHP view files
    "./Views/_partials/**/*.php", // ✅ partials too
    "./index.php",               // ✅ root index.php
    "./src/**/*.{html,js}",       // ✅ if you have test HTML or JS files in src
    "./node_modules/flowbite/**/*.js",
   ],
   theme: {
     extend: {
       colors: {
         'primary-tan': '#ffefe7',
         'primary-light-tan': '#fff7f3',
         'primary-purple': '#534B6F',
       }
     }
   },
   plugins: [
     forms,
     flowbite
   ],
 }
 
 tailwind.config = {
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        primary: {"50":"#eff6ff","100":"#dbeafe","200":"#bfdbfe","300":"#93c5fd","400":"#60a5fa","500":"#3b82f6","600":"#2563eb","700":"#1d4ed8","800":"#1e40af","900":"#1e3a8a","950":"#172554"}
      }
    },
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
    }
  }
}