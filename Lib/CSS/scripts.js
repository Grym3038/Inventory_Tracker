

const setFavicon = () => {
    const favicon = document.querySelector('link[rel="icon"]');
    favicon.href = (window.matchMedia('(prefers-color-scheme: dark)').matches)
                    ? 'Lib\Images\Logo_Mower_White.svg'
                    : 'Lib\Images\Logo_Mower_Black.svg';
};

setFavicon();

window
    .matchMedia('(prefers-color-scheme: dark)')
    .addEventListener('change', setFavicon);
