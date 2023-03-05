import React, { useState } from 'react';
import PageProfilComponent from './PageProfilComponent';

export default function CircleContainerForProfilePictureComponent(props) {
    const [modalShow, setModalShow] = useState(false);

    const handleModalClose = () => {
      setModalShow(false);
    };
  
    const handleModalOpen = () => {
      setModalShow(true);
    };

    return (
        <>
        <div className="circle-image-container" onClick={handleModalOpen} title="Voir le profil">
            <div className="circle-image" style={{ backgroundImage: `url(${props.imageUrl})` }}></div>
        </div>

        <PageProfilComponent show={modalShow} onHide={handleModalClose}/>
    </>
    );
}