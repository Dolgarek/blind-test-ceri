import React, {useEffect, useState} from 'react';
import {CountdownCircleTimer} from "react-countdown-circle-timer";


export default function (props) {
    const [isPlaying, setIsPlaying] = useState(false)
    let audioPlayer = undefined
    let audioSource = undefined
    let currentSongIndex = 0
    let currentSong = {}
    let gameState = 0
    let reponse = <div className="timer">C'est fini!</div>

    useEffect(() => {
        audioPlayer = document.getElementById('audioPlayer');
        audioSource = document.getElementById('audioSource');
        if (props.musiques.length > 0) {
            currentSongIndex = 0
            currentSong = props.musiques[currentSongIndex]
            reponse = <div className="timer">{currentSong.nom}</div>
            setIsPlaying(true)
            gameState = 1
            if (audioPlayer === undefined && audioSource === undefined) {
                audioPlayer = document.getElementById('audioPlayer');
                audioSource = document.getElementById('audioSource');
            }
            audioPlayer.currentTime = parseFloat(currentSong.timestamp) || 0; // Définir le point de départ de la lecture en fonction du timestamp
            audioPlayer.volume = 0.01; // Ajustez le volume au niveau souhaité

            // Chargez l'audio et commencez la lecture
            audioSource.src = 'api/playSong/' + currentSong.id;
            audioPlayer.load();
            audioPlayer.play();
        }

    }, []);

    const renderTime = ({ remainingTime }) => {
        if (remainingTime === 0) {
            return 42;
        }
        return (
          <div className="timer">
            <div className="value">{remainingTime}</div>
          </div>
        );
    };

    return (
        <div className='containerAccueil'>
            <div>
                <audio id="audioPlayer" controls>
                    <source id="audioSource" src="" type="audio/mpeg"></source>
                </audio>
            </div>
            <div className="timer-wrapper">
                <CountdownCircleTimer
                    isPlaying
                    duration={props.countdownSeconds}
                    colors={["#004777", "#F7B801", "#A30000", "#A30000"]}
                    colorsTime={[10, 6, 3, 0]}
                    onComplete={() => {
                        if (audioPlayer === undefined && audioSource === undefined) {
                            audioPlayer = document.getElementById('audioPlayer');
                            audioSource = document.getElementById('audioSource');
                        }
                        audioPlayer.pause()
                        currentSongIndex++
                        currentSongIndex < props.musiques.length ? gameState = 1 : gameState = 0
                        console.log('Game State: ' + gameState, '\nCurrent Song Index: ' + currentSongIndex, '\nCurrent Song: ' + currentSong, '\nMusiques length: ' + props.musiques.length)
                        if (gameState === 1) {
                            currentSong = props.musiques[currentSongIndex]
                            audioSource.src = 'api/playSong/' + currentSong.id;
                            audioPlayer.load();
                            audioPlayer.currentTime = parseFloat(currentSong.timestamp) || 0;
                            setTimeout(() => {
                                audioPlayer.play();
                            }, 1500)
                                console.log(2)
                            return { shouldRepeat: true, delay: 1.5 } // repeat animation in 1.5 seconds
                        }


                    }}>
                    {(remainingTime) => {
                        if (remainingTime.remainingTime === 0) {
                            console.log(gameState, currentSong.nom, currentSongIndex, props.musiques.length, props.musiques)
                            if (gameState === 0 && currentSong.nom === undefined) {
                                return <div className="timer"><div id="remainingTime" className="value" style={{fontSize: '1rem'}}>{props.musiques[0].nom}</div></div>
                            }
                            if (gameState === 1 && props.musiques.length === currentSongIndex + 1) {
                                return <div className="timer"><div id="remainingTime" className="value" style={{fontSize: '1rem'}}>{currentSong.nom}<br/><div style={{fontSize: '0.5rem'}}>C'est fini !</div></div></div>
                            }
                            if (gameState === 1) {
                                return <div className="timer"><div id="remainingTime" className="value" style={{fontSize: '1rem'}}>currentSong.nom</div></div>
                            }
                            return <div className="timer"><div id="remainingTime" className="value">"C'est fini !"</div></div>
                        }
                        return <div className="timer"><div id="remainingTime" className="value">{remainingTime.remainingTime}</div></div>
                    }}
                </CountdownCircleTimer>
            </div>
            <div>

            </div>


        </div>
    )
}