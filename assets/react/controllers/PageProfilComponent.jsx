import React, { useState } from 'react';
import { Modal, Button, Form } from 'react-bootstrap';

export default function EditProfileModal(props) {
    const [editMode, setEditMode] = useState(false);
    const [firstName, setFirstName] = useState("Jonathan");
    const [lastName, setLastName] = useState("Zephir");
    const [username, setUsername] = useState("JoJo");
    const [email, setEmail] = useState("jojoZeph@gmai.com");
    const [password, setPassword] = useState("password123");
    
    const handleEditButtonClick = () => {
        setEditMode(true);
    };

    const handleSaveButtonClick = () => {
        setEditMode(false);
    };

    const handleCancelButtonClick = () => {
        setFirstName("Jonathan");
        setLastName("Zephir");
        setUsername("JoJo");
        setEmail("jojoZeph@gmail.com");
        setPassword("password123");
        setEditMode(false);
    };
  return (
    <Modal show={props.show} onHide={props.onHide} size="lg">
        <Modal.Header closeButton>
            <Modal.Title className='welcomeText text-center'>Votre profil</Modal.Title>
        </Modal.Header>
        <Modal.Body>
            <Form>
                <Form.Group controlId="formFirstName" className='form-group-sm'>
                    <Form.Label className='profileLabelText'>Prénom :</Form.Label>
                    <Form.Control type="text" placeholder="Entrez votre prénom" name="firstName" value={firstName}
                        plaintext={!editMode} readOnly={!editMode} onChange={(event)=>{setFirstName(event.target.value);}} className="form-control-sm"/>
                </Form.Group>
                <Form.Group controlId="formLastName" className='form-group-sm'>
                    <Form.Label className='profileLabelText'>Nom :</Form.Label>
                    <Form.Control type="text" placeholder="Entrez votre nom" name="lastName" value={lastName}
                        plaintext={!editMode} readOnly={!editMode} onChange={(event)=>{setLastName(event.target.value);}} className="form-control-sm"/>
                </Form.Group>
                <Form.Group controlId="formUsername" className='form-group-sm'>
                    <Form.Label className='profileLabelText'>Nom d'utilisateur :</Form.Label>
                    <Form.Control type="text" placeholder="Entrez votre nom d'utilisateur" name="username" value={username}
                        plaintext={!editMode} readOnly={!editMode} onChange={(event)=>{setUsername(event.target.value);}} className="form-control-sm"/>
                </Form.Group>
                <Form.Group controlId="formEmail" className='form-group-sm'>
                    <Form.Label className='profileLabelText'>Adresse e-mail :</Form.Label>
                    <Form.Control type="email" placeholder="Entrez votre adresse e-mail" name="email" value={email} 
                        plaintext={!editMode} readOnly={!editMode} onChange={(event)=>{setEmail(event.target.value);}} className="form-control-sm"/>
                </Form.Group>
                <Form.Group controlId="formPassword" className='form-group-sm'>
                    <Form.Label className='profileLabelText'>Mot de passe :</Form.Label>
                    <Form.Control type="password" placeholder="Entrez votre mot de passe" name="password" value={password}
                       plaintext={!editMode} readOnly={!editMode} onChange={(event)=>{setPassword(event.target.value);}} className="form-control-sm"/>
                </Form.Group>
            </Form>
        </Modal.Body>
        <Modal.Footer>
            {!editMode ? (
                <Button variant="mybtn" onClick={handleEditButtonClick}> Modifier </Button>) : (
            <>
                <Button variant="mybtnDeconnexion" onClick={handleCancelButtonClick}> Annuler </Button>
                <Button variant="mybtn" onClick={handleSaveButtonClick}> Enregistrer </Button>
            </>
            )}
        </Modal.Footer>
    </Modal>
  );
}
