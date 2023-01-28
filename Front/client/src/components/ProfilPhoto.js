import React, { useEffect, useState } from 'react'
import DefaultPhotoProfil from "../assets/images/photos/default-profil-picture.svg";



const ProfilPhoto = () => {

    return (
        <div className="photo-profil">
            <img src={DefaultPhotoProfil}/>
        </div>
    )
}

export default ProfilPhoto;
