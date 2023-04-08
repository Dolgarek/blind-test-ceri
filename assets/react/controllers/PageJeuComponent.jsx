/*
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
                                return <div className="timer"><div id="remainingTime" className="value" style={{fontSize: '1rem'}}>{currentSong.nom}</div></div>
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
}*/
import React, { useEffect, useState } from "react";
import { useTimer } from "use-timer";
import {Form} from "react-bootstrap";

export default function PageJeuComponent(props) {
    const [currentIndex, setCurrentIndex] = useState(0);
    const [finishedMode, setFinishedMode] = useState(false);
    const [answer, setAnswer] = useState('');
    const { time, start, pause, reset } = useTimer({
        endTime: 0,
        initialTime: props.countdownSeconds,
        timerType: "DECREMENTAL",
    });
    let currentSong
    let audioPlayer = undefined
    let audioSource = undefined
    let musiques = JSON.parse(props.musiques)
    let result = JSON.parse(props.musiques)

    useEffect(() => {
        currentSong = musiques[currentIndex]
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
        start();
    }, []);

    useEffect(() => {
        if (time === 0) {
            pause();
            if(answer===JSON.parse(props.musiques)[currentIndex].titre){
                result[currentIndex].answerCorrect=true;
            }
            result[currentIndex].answer=answer;
            console.log(result)
            setFinishedMode(true);
            if (audioPlayer === undefined && audioSource === undefined) {
                audioPlayer = document.getElementById('audioPlayer');
                audioSource = document.getElementById('audioSource');
            }
            audioPlayer.pause();
            setTimeout(() => {
                if (currentIndex < musiques.length - 1) {
                    setCurrentIndex(currentIndex + 1);

                    currentSong = musiques[currentIndex+1]
                    //console.log(currentSong)
                    /*let oldSong = musiques[currentIndex]
                    if(answer===oldSong.titre){
                        props.musiques[currentIndex].answerCorrect=true;
                    }
                    oldSong.answer=answer;*/
                    // audioPlayer.currentTime = parseFloat(currentSong.timestamp) || 0; // Définir le point de départ de la lecture en fonction du timestamp
                    // audioPlayer.volume = 0.01; // Ajustez le volume au niveau souhaité

                    // Chargez l'audio et commencez la lecture
                    audioSource.src = 'api/playSong/' + currentSong.id;
                    audioPlayer.load();
                    audioPlayer.currentTime = parseFloat(currentSong.timestamp) || 0; // Définir le point de départ de la lecture en fonction du timestamp
                    audioPlayer.volume = 0.2; // Ajustez le volume au niveau souhaité
                    audioPlayer.play();
                    setFinishedMode(false);
                    setAnswer("");
                    reset();
                    start();
                } else {
                    audioPlayer.pause();
                    console.log(result)
                    window.location.assign(`finJeu?music=${JSON.stringify(result)}`)
                }
            }, 5000);
        }
    }, [time]);

    function verifyMusic(){
        if(answer===currentSong.titre){
            currentSong.answerCorrect=true;
        }
        currentSong.answer=answer;
        //console.log(currentSong.answer);
    }

    return (
        <div>
            <div hidden>
                <audio id="audioPlayer" controls>
                    <source id="audioSource" src="" type="audio/mpeg"></source>
                </audio>
            </div>
            {/*<h1>{musiques[currentIndex].titre}</h1>*/}
            <p>Temps restant : {time}</p>
            <div className="answer-wrapper">
                <Form>
                    <Form.Group controlId="formAnswer" className='form-group-sm'>
                        <Form.Label className='profileLabelText'>Réponse :</Form.Label>
                        <Form.Control type="text" placeholder="Entrez une réponse" name="_answer" value={answer}
                                      onChange={(event)=>{setAnswer(event.target.value);}} plaintext={finishedMode} readOnly={finishedMode} className="form-control-sm"/>
                    </Form.Group>
                </Form>
                {finishedMode ? (<div className={JSON.parse(props.musiques)[currentIndex].titre === answer ? 'text-success' : 'text-danger'}>La bonne réponse est : {currentSong ? currentSong.titre : JSON.parse(props.musiques)[currentIndex].titre}</div>) : (<div></div>)}
            </div>
        </div>
    );
}
