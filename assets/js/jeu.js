export function gameStart(id, ts) {
    const audioPlayer = document.getElementById('audioPlayer');
    const audioSource = document.getElementById('audioSource');
    const urlParams = new URLSearchParams(window.location.search);
    const timestamp = parseFloat(ts) || 0; // Utiliser 0 comme valeur par défaut

    audioPlayer.currentTime = timestamp; // Définir le point de départ de la lecture en fonction du timestamp
    audioPlayer.volume = 0.01; // Ajustez le volume au niveau souhaité

    // Chargez l'audio et commencez la lecture
    audioSource.src = ''.id;
    audioPlayer.load();
    audioPlayer.play();

    setTimeout(() => {
        const fadeDuration = 1000; // Durée de la baisse de volume en millisecondes
        const fadeInterval = 100; // Intervalle entre les changements de volume en millisecondes
        const fadeStep = audioPlayer.volume / (fadeDuration / fadeInterval); // Calcul de l'incrément de volume à chaque intervalle

        const fadeOutInterval = setInterval(() => {
            audioPlayer.volume - 0.001 > 0 ? audioPlayer.volume -= 0.001 : audioPlayer.volume = 0;

            if (audioPlayer.volume <= 0) {
                clearInterval(fadeOutInterval);
                audioPlayer.pause();
                audioPlayer.volume = 0.01
            }
        }, fadeInterval);
    }, 10000);
}