import React, {useState} from 'react';
import {Button, Form} from 'react-bootstrap';
import Card from 'react-bootstrap/Card';


function LoginForm(props) {
    const [username, setUsername] = useState('');
    const [password, setPassword] = useState('');
    const [nom, setNom] = useState('');
    const [prenom, setPrenom] = useState('');
    const [terms, setTerms] = useState(false);
    const [error] = useState(props.error);

    return (
        <div>
            <div className='welcomeText'>Blindtest !</div>
            {error &&
                <div className="row mt-2 mb-0">
                    <div className="col-6 offset-3">
                        <div className="alert alert-danger text-center" role="alert">
                            Erreur lors de la création du compte merci de vérifier vos infos (attention mdp > 6 char)
                        </div>
                    </div>
                </div>
            }
            <div className='loginCard'>
                <Form action='/register' method='post'>
                    <Card className='mx-auto'>
                        <Card.Body>
                            <Card.Header className='loginText text-center'> Inscription</Card.Header>
                                <Form.Group controlId="formUsername" className='form-group-sm'>
                                    <Form.Label className='loginLabelText'>Nom d'utilisateur :</Form.Label>
                                    <Form.Control type="text" placeholder="Entrez votre nom d'utilisateur" name="username"
                                                  value={username}
                                                  onChange={(event) => {
                                                      setUsername(event.target.value);
                                                  }} className="form-control"/>
                                </Form.Group>
                                <div className='passwordLabelText'>
                                    <Form.Group controlId="formNom" className='form-group-sm'>
                                        <Form.Label className='loginLabelText'>Nom: </Form.Label>
                                        <Form.Control type="text" placeholder="Entrez votre Nom" name="nom"
                                                      value={nom}
                                                      onChange={(event) => {
                                                          setNom(event.target.value);
                                                      }} className="form-control"/>
                                    </Form.Group>
                                </div>
                                <div className='passwordLabelText'>
                                    <Form.Group controlId="formPrenom" className='form-group-sm'>
                                        <Form.Label className='loginLabelText'>Prénom: </Form.Label>
                                        <Form.Control type="text" placeholder="Entrez votre Prénom" name="prenom"
                                                      value={prenom}
                                                      onChange={(event) => {
                                                          setPrenom(event.target.value);
                                                      }} className="form-control"/>
                                    </Form.Group>
                                </div>
                                <div className='passwordLabelText'>
                                    <Form.Group controlId="formPassword" className='form-group-sm'>
                                        <Form.Label className='loginLabelText'>Mot de passe :</Form.Label>
                                        <Form.Control type="password" placeholder="Entrez votre mot de passe"
                                                      name="password" value={password}
                                                      onChange={(event) => {
                                                          setPassword(event.target.value);
                                                      }} className="form-control"/>
                                    </Form.Group>
                                </div>
                                <div className='passwordLabelText'>
                                    <Form.Group controlId="formTerms" className='form-group-sm'>
                                        <Form.Label className='loginLabelText'>J'accepte les termes du CGU :</Form.Label>
                                        <Form.Check type="checkbox"
                                                      name="terms" value={terms}
                                                      onChange={() => {
                                                          setTerms(!terms);
                                                      }} className="form-control"/>
                                    </Form.Group>
                                </div>
                        </Card.Body>
                        <Card.Footer>
                            <div className='mybtn-inscription'>
                                <Button variant="mybtn" type="submit"> S'inscrire </Button>
                            </div>
                        </Card.Footer>
                    </Card>
                </Form>
            </div>
        </div>
    );
}

export default LoginForm;
