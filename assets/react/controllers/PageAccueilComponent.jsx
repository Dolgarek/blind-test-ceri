import React, {useEffect, useState} from 'react';
import { Button } from 'react-bootstrap';
import { FaSignOutAlt } from 'react-icons/fa';
import CircleContainerForProfilePictureComponent from './CircleContainerForProfilePictureComponent'
import RGPD from './PageRGPDComponent'


export default function (props) {
    const [showModal, setShowModal] = useState(showModal);

    const handleShowModal = () => setShowModal(true);
    const handleHideModal = () => setShowModal(false);

    //TODO: Implement call to API to ensure RGPD is accepted
    /*
    * await axios.get('/api/rgpd/accepted')
    * .then((response) => {
    *  if (response.data.accepted) {
    *   setShowModal(false);
    * } else {
    *  setShowModal(true);
    * }
    * })
    * .catch((error) => {
    * console.log(error);
    * });
    * */

    return (
        <div>
            <div>
                <CircleContainerForProfilePictureComponent id={props.id} username={props.username} firstName={props.firstName} lastName={props.lastName} password={props.password} imageUrl= {props.imageUrl}/>
            </div>
            <RGPD showModal={showModal}  onHide={handleHideModal}  title="RGPD Consigne"></RGPD>


            <div className='containerAccueil'>
                <div className='welcomeText'>Bienvenue {props.username} !</div>
                <div className='introductionText'>Blindtest est le meilleur endroit pour tester vos connaissances musicales en ligne !
                    Jouez avec vos propres musiques ou avec celles de notre sélection de blindtests amusants et stimulants.</div>
                <div className='positionButtonCenter'>
                    <Button href="/config" variant="mybtn" size="xxl">Nouvelle partie</Button>
                </div>
                <div className='positionButtonCenter'>
                    <Button href="/musique" variant="mybtn" size="xxl">Importer des musiques</Button>
                </div>
                <div className='positionButtonCenter'>
                    <Button href="/theme" variant="mybtn" size="xxl">Gérer les thèmes</Button>
                </div>
            </div>
            {props.role === 'ROLE_ADMIN' ? (<div className='positionButtonDownLeft'>
                <Button href="/logout" variant="mybtnDeconnexion" size="xxl">Déconnexion <FaSignOutAlt/></Button>
            </div>) : (<div></div>)}
        </div>
    )
}