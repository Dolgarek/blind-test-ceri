import React, { useState } from 'react';
import { Button, Form } from 'react-bootstrap';
import Card from 'react-bootstrap/Card';


function LoginForm() {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');

  const handleConnexionButtonClick = () => {
};


  return (
    <div className='imageBackgroundLogin'>
      <div className='welcomeText'>Blindtest !</div>
      <div className='loginCard'>
        <Card className='mx-auto'>
          <Card.Body>
            <Card.Header className='loginText text-center'> Connexion</Card.Header>
            <Form>
              <Form.Group controlId="formUsername" className='form-group-sm'>
                <Form.Label className='loginLabelText'>Nom d'utilisateur :</Form.Label>
                <Form.Control type="text" placeholder="Entrez votre nom d'utilisateur" name="username" value={username}
                  onChange={(event)=>{setUsername(event.target.value);}} className="form-control"/>
              </Form.Group>
              <Form.Group controlId="formPassword" className='form-group-sm'>
                <Form.Label className='loginLabelText'>Mot de passe :</Form.Label>
                <Form.Control type="password" placeholder="Entrez votre mot de passe" name="password" value={password}
                  onChange={(event)=>{setPassword(event.target.value);}} className="form-control"/>
              </Form.Group>
            </Form>
          </Card.Body>
          <Card.Footer>
            <Button variant="mybtn" onClick={handleConnexionButtonClick}> Se connecter </Button>
            <div>
              Vous n'êtes pas encore membre? Veuillez vous <a href="/inscription">inscrire</a>
            </div>
          </Card.Footer>
        </Card>
      </div>
    </div>
  );
}

export default LoginForm;
