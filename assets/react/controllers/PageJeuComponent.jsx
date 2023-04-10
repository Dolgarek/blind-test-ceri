import React, { useEffect, useState } from "react";
import { useTimer } from "use-timer";
import {Form} from "react-bootstrap";
import axios from "axios";
import uuid from 'react-native-uuid';


function postAnswer(data, index, ssid, titre) {
    console.log(data, index, ssid)
    axios.post('/config/answer', {'answer': data, 'index': index, 'ssid': ssid, 'titre': titre})
        .then((response) => {
            console.log(response)
        }).catch((error) => {console.log(error)})
}
export default function PageJeuComponent(props) {
    const [currentIndex, setCurrentIndex] = useState(0);
    const [finishedMode, setFinishedMode] = useState(false);
    const [answer, setAnswer] = useState('');
    const [testAnswer, setTest] = useState('');
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
    const [ssid, setSsid] = useState(uuid.v4())

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
        result[currentIndex].answer=answer;
        if(answer===JSON.parse(props.musiques)[currentIndex].titre){
            result[currentIndex].answerCorrect=true;
        }
        if (time === 0) {
            pause();
            result[currentIndex].answer=answer;
            if(answer===JSON.parse(props.musiques)[currentIndex].titre){
                result[currentIndex].answerCorrect=true;
            }
            //result[currentIndex].answer=answer;
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

                    // Chargez l'audio et commencez la lecture
                    audioSource.src = 'api/playSong/' + currentSong.id;
                    audioPlayer.load();
                    audioPlayer.currentTime = parseFloat(currentSong.timestamp) || 0; // Définir le point de départ de la lecture en fonction du timestamp
                    audioPlayer.volume = 0.01; // Ajustez le volume au niveau souhaité
                    audioPlayer.play();
                    setFinishedMode(false);
                    setAnswer("");
                    reset();
                    start();
                } else {
                    audioPlayer.pause();
                    window.location.assign(`finJeu?ssid=${ssid}`)
                }
            }, 5000);
        }
    }, [time, answer]);

    /*useEffect(() => {
        console.log(answer);
        console.log(result[currentIndex])
        result[currentIndex].answer=answer;
        console.log(result[currentIndex])
    }, [answer]);*/

    //Ajouter bouton validation + fonction avec appel axios pour poster réponse



    return (
        <div>
            <div hidden>
                <audio id="audioPlayer" controls>
                    <source id="audioSource" src="" type="audio/mpeg"></source>
                </audio>
            </div>
            <div className='containerAccueil'>
                <div className="centerContainer">
                    <div className='welcomeText'>Il vous reste :</div>
                    <div className='welcomeTextLato'>{time}</div>
                    <div className="answer-wrapper">
                        <Form>
                            <Form.Group controlId="formAnswer" className='form-group-sm'>
                                <Form.Label className='profileLabelText'>Réponse :</Form.Label>
                                <Form.Control type="text" placeholder="Entrez une réponse" name="_answer" value={answer}
                                            onChange={(event)=>{setAnswer(event.target.value);setAnswer(event.target.value)}} plaintext={finishedMode} readOnly={finishedMode} className="form-control-sm"/>
                            </Form.Group>
                        </Form>
                        {finishedMode ? (<div className={JSON.parse(props.musiques)[currentIndex].titre === answer ? 'text-success' : 'text-danger'}>La bonne réponse est : {currentSong ? currentSong.titre : JSON.parse(props.musiques)[currentIndex].titre}</div>) : (<div></div>)}
                        {finishedMode ? postAnswer(answer, currentIndex, ssid, JSON.parse(props.musiques)[currentIndex].titre) : console.log("not finished")}
                    </div>
                </div>
            </div>
        </div>
    );
}
