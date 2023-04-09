import React, { useState } from 'react';
import { Button, Modal, Form } from 'react-bootstrap';
import Card from 'react-bootstrap/Card';
import RGPD from './PageRGPDComponent';

function LoginForm() {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');


  return (
    <div>
      <div className='welcomeText'>Blindtest !</div>
      <div className='loginCard'>
        <Card className='mx-auto'>
          <Card.Body>
            <Card.Header className='loginText text-center'> Connexion</Card.Header>
            <Form action='/login' method='post'>
              <Form.Group controlId="formUsername" className='form-group-sm'>
                <Form.Label className='loginLabelText'>Nom d'utilisateur :</Form.Label>
                <Form.Control type="text" placeholder="Entrez votre nom d'utilisateur" name="_username" value={username}
                  onChange={(event)=>{setUsername(event.target.value);}} className="form-control"/>
              </Form.Group>
              <div className='passwordLabelText'>
              <Form.Group controlId="formPassword" className='form-group-sm'>
                <Form.Label className='loginLabelText'>Mot de passe :</Form.Label>
                <Form.Control type="password" placeholder="Entrez votre mot de passe" name="_password" value={password}
                  onChange={(event)=>{setPassword(event.target.value);}} className="form-control"/>
              </Form.Group>
                <div className='mybtn-login'>
                  <Button variant="mybtn" type="submit"> Se connecter </Button>
                  
                </div>
              </div>
            </Form>
          </Card.Body>
          <Card.Footer>
            <div className='inscriptionLabelText'>
              Vous n'êtes pas encore membre? Veuillez vous <a href="/register">inscrire</a>
            </div>
          </Card.Footer>
        </Card>
      </div>
    </div>
  );
}

export default LoginForm;
