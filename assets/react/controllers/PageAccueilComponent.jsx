import React from 'react';
import { Button } from 'react-bootstrap';
import { FaSignOutAlt } from 'react-icons/fa';
import CircleContainerForProfilePictureComponent from './CircleContainerForProfilePictureComponent'


export default function (props) {
    return (
        <div className='imageBackground'>
            <div>
                <CircleContainerForProfilePictureComponent id={props.id} username={props.username} firstName={props.firstName} lastName={props.lastName} password={props.password} imageUrl= {props.imageUrl}/>
            </div>
            <div className='containerAccueil'>
                <div className='welcomeText'>Bienvenue {props.username} !</div>
                <div className='introductionText'>Blindtest est le meilleur endroit pour tester vos connaissances musicales en ligne !
                    Jouez avec vos propres musiques ou avec celles de notre sélection de blindtests amusants et stimulants.</div>
                <div className='positionButtonCenter'>
                    <Button variant="mybtn" size="xxl">Nouvelle partie</Button>
                </div>
                <div className='positionButtonCenter'>
                    <Button variant="mybtn" size="xxl">Importer des musiques</Button>
                </div>
            </div>
            <div className='positionButtonDownLeft'>
                <Button href="/logout" variant="mybtnDeconnexion" size="xxl">Déconnexion <FaSignOutAlt /></Button>
            </div>
        </div>
    )
}