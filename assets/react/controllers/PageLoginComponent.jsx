import React, { useState } from 'react';

function LoginForm() {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');

  const handleSubmit = (event) => {
    event.preventDefault();
    // Vérifiez les informations de connexion ici
  };

  return (
    <div className='imageBackgroundLogin'>

      <div className='welcomeText'>Blindtest !</div>
          

      <div className='loginCard'>
      <form onSubmit={handleSubmit}>

      <div>
      <label htmlFor="username">Nom d'utilisateur:</label>
      <input type="text" id="username"value={username} onChange={(event) => setUsername(event.target.value)}
      />
      </div>
      <div>
      <label htmlFor="password">Mot de passe:</label>
      <input
        type="password"
        id="password"
        value={password}
        onChange={(event) => setPassword(event.target.value)}
      /></div>
      <div>
      <button type="submit">Se connecter</button>
      </div>
      <div>
      <button type="submit">S'inscrire</button>
      </div>
    </form>
    </div>
    </div>
  );
}

export default LoginForm;
