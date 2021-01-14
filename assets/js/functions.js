function increaseHeight() {
    if ((document.getElementById('main-container').offsetHeight + 96) < window.innerHeight) {
        document.getElementById('main-container').style.height = (window.innerHeight - 96) + 'px';
    } else {
        document.getElementById('main-container').style.minHeight = (window.innerHeight - 96) + 'px';
    }

}