import axios from 'axios';
import React, { useEffect, useState } from 'react'
import '../assets/css/modales/modale-participants.css';
import ProfilPhoto from "../components/ProfilPhoto";
import iconADelete from "../assets/images/icons/cross-delete.svg";


const ModalParticipants = () => {
    const [userInfo, setUserInfo] = useState([]);
    const [totalUsers, setTotalUsers] = useState(0);

    useEffect(() => {
        axios.get('http://localhost:1501/mes_colocs/1/charge')
        .then(response => {
            const userInfo = Object.values(response.data.InfoColoc.user_info);
            setUserInfo(userInfo);
            setTotalUsers(userInfo.length);
        });
    }, []);

   

    return (

        <div className='vh-100 modale modale-participants flex-center'>
            <div className="box-shadow-modale box-model modale-participants-container">
                <div className="box-model-scroll">
                    <div className="cross-modale"></div>
                    <h1 className="text-center">Les participants</h1>
                    <p className="satoshi-bold para-15 nb-participants icon-participant">{totalUsers} participants</p>
                    <div className="participants-list">{userInfo.map(user =>
                        <div className='box-model participant-item' key={user.user_id}>
                            <div className="participant-info">
                                <ProfilPhoto />
                                <p className="para-18">{user.user_username}</p>
                            </div>
                            <div className="icon-delete">
                                <img src={iconADelete}/>
                            </div>
                        </div>
                    )}
                    </div>
                </div>
            </div>
        </div>
    )
};

export default ModalParticipants