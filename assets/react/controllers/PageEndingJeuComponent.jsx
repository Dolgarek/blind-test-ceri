import React from 'react';
import CircleContainerForProfilePictureComponent from './CircleContainerForProfilePictureComponent'
import Right from '../../images/Right.png'
import Wrong from '../../images/Wrong.png'


export default function (props) {
    // const search = window.location.search; 
    // const params = new URLSearchParams(search); 
    // var IdFromURL = params.get('music');
    // var musics = JSON.parse(IdFromURL); 
    
    const musics = [
        {
            "id": 1,
            "url": "something/url",
            "titre": "Test",
            "answerCorrect": true,
            "answer":"Test"
        },
        {
            "id": 2,
            "url": "somethingElse/url",
            "titre": "Something",
            "answerCorrect": false,
            "answer":"So"
        }];

    return (
        <div className='imageBackground'>
            <div>
                <CircleContainerForProfilePictureComponent id={props.id} username={props.username} firstName={props.firstName} lastName={props.lastName} password={props.password} imageUrl= {props.imageUrl}/>
            </div>
            <div className='containerAccueil'>
                <div className='welcomeText'>Voici vos résultats ! </div>
                <div className='tableContainer'>
                    <table>
                        <tbody>
                            <tr>
                            <th className='introductionText'>Les bonnes réponses</th>
                            <th className='introductionText'>Vos réponses</th>
                            <th className='introductionText'>Résultats</th>
                            </tr>
                            {musics.map((val, key) => {
                            return (
                                <tr key={val.id}>
                                <td className='resultTableText'>{val.titre}</td>
                                <td className='resultTableText'>{val.answer}</td>
                                {val.answerCorrect ?(
                                    <td><img src={Right} alt="Right" /></td>
                                    ) : (
                                    <>
                                    <td><img src={Wrong} alt="Wrong" /></td>
                                    </>
                                )}
                                
                                </tr>
                            )
                            })}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    )
}