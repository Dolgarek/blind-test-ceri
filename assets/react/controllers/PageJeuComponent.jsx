import React from 'react';
import ReactDOM from "react-dom";
import { CountdownCircleTimer } from "react-countdown-circle-timer";




export default function (props) {
    
    const renderTime = ({ remainingTime }) => {
        if (remainingTime === 0) {
          return <div className="timer">C'est fini!</div>;
        }
        return (
          <div className="timer">
            <div className="value">{remainingTime}</div>
          </div>
        );
    };
    return (
        <div className='containerAccueil'>
            <div className="timer-wrapper">
                <CountdownCircleTimer
                    isPlaying
                    duration={props.countdownSeconds}
                    colors={["#004777", "#F7B801", "#A30000", "#A30000"]}
                    colorsTime={[10, 6, 3, 0]}
                    onComplete={() => ({  })}>{renderTime}</CountdownCircleTimer>
            </div>
            <div>
                
            </div>
            

        </div>
    )
}