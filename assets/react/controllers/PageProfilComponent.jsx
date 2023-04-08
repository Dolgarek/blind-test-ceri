import React, { useState } from 'react';
import axios from 'axios';
import { Modal, Button, Form } from 'react-bootstrap';

export default function EditProfileModal(props) {
    const [editMode, setEditMode] = useState(false);
    const [firstName, setFirstName] = useState(props.firstName);
    const [lastName, setLastName] = useState(props.lastName);
    const [username] = useState(props.username);
    const [password, setPassword] = useState("");
    const [avatarFile, setAvatarFile] = useState(props.avatarFile);
    
    const handleEditButtonClick = () => {
        setEditMode(true);
    };

    const handleSaveButtonClick = async () => {
        console.log(avatarFile);
        let formData = new FormData();
        formData.append('username', username);
        formData.append('firstName', firstName);
        formData.append('lastName', lastName);
        formData.append('password', password);
        formData.append('avatarFile', avatarFile);
        await axios.post("/utilisateur/api/me/edit/" + props.id, {username, lastName, firstName, password})
            .then(res => console.log(res))
            .catch(err => console.log(err))
        setEditMode(false);
    };

    const handleFileSelect = (event) => {
        const file = event.target.files[0];
        setAvatarFile(file);
    };

    const handleCancelButtonClick = () => {
        setFirstName(props.firstName);
        setLastName(props.lastName);
        setPassword("");
        setAvatarFile(props.avatarFile);
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
                        plaintext readOnly className="form-control-sm"/>
                </Form.Group>
                <Form.Group controlId="formPassword" className='form-group-sm'>
                    <Form.Label className='profileLabelText'>Mot de passe :</Form.Label>
                    <Form.Control type="password" placeholder="Entrez votre mot de passe" name="password" value={password}
                       plaintext={!editMode} readOnly={!editMode} onChange={(event)=>{setPassword(event.target.value);}} className="form-control-sm"/>
                </Form.Group>
                <Form.Group controlId="avatarFile" className='form-group-sm'>
                    <Form.Label className=''>Avatar :</Form.Label>
                    <Form.Control type="file" name="files-elect" onChange={handleFileSelect} className="form-control-sm"/>
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
