import Cookies from 'js-cookie';
import { useState } from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faXmark } from "@fortawesome/free-solid-svg-icons";
import '../../assets/css/components/modal/common-modal.css';
import '../../assets/css/components/modal/add-depense.css';
import Multiselect from 'multiselect-react-dropdown';



const AddColoc = (props) => {
    const colocId = props.colocationInfo.colocation_id
    const userInfo = props.userInfo
    const [title, setTitle] = useState('');
    const [amount, setAmount] = useState('');
    const [status, setStatus] = useState('');
    const [paymaster, setPaymaster] = useState([]);
    const [participant, setParticipant] = useState([]);
    const listUser = [];


    Object.keys(userInfo).map(key => {
        const userObj = {
            username: userInfo[key].user_username.replace(/"/g, ''),
            id: userInfo[key].user_id,
          };
          listUser.push(userObj);
    });
    
    const handleSelectPaymaster = (selected) => {
        setPaymaster(selected);
    };
    
    const handleSelect = (selected) => {
        setParticipant(selected);
    };

    
    const handleSubmit = async e => {
        e.preventDefault();
        let jwtToken = Cookies.get('token');
        await fetch(`http://localhost:1501/mes_colocs/${colocId}/add_depense`, {
            method: 'POST',
            mode:"cors",
            credentials:"include",
            headers: new Headers({
                "Authorization": "Bearer " + jwtToken,
                "content-type": "application/x-www-form-urlencoded",
            }),
            body: new URLSearchParams({
                title, amount, paymaster:JSON.stringify(paymaster), participant:JSON.stringify(participant)
            })
        }).then(data => {
            setStatus(data.status);
        })
    }

    return (
        <div className="modal-background">
            <div className="modal-container-depense">
                <FontAwesomeIcon className="close-icon" icon={faXmark} onClick={props.onClose}></FontAwesomeIcon>
                <h2 className="title">Ajouter une dépense</h2>
                <form onSubmit={handleSubmit} className='form-add-depense'>
                    <div className="row">
                        <label className='column'>
                            Titre de la dépense
                            <input type="text" name="title" placeholder='Loyer' value={title} onChange={e => setTitle(e.target.value)} />
                        </label>
                        <label className='column'>
                            Montant
                            <input type="text" name="amount" placeholder='150' value={amount} onChange={e => setAmount(e.target.value)} />
                        </label>
                    </div>

                    <div className="row">
                        <label className='column payeur'>
                            Qui paye ?
                            <Multiselect
                                displayValue="username"
                                placeholder="Payeur"
                                emptyRecordMsg="Pas de payeur"
                                singleSelect={true}
                                options={listUser}
                                // { border: "none", "border-bottom": "1px solid blue", "border-radius": "0px" } }
                                onSelect={handleSelectPaymaster}
                            />
                        </label>
                        <label className='column'>
                            Qui participe ?
                            <Multiselect
                                displayValue="username"
                                placeholder="Paricipants"
                                emptyRecordMsg="Pas de participant"
                                options={listUser}
                                style={{
                                    chips: { 
                                        background:
                                        "#6b6b6b", 
                                        color: "white",
                                    },
                                }}
                                onSelect={handleSelect}
                            />
                        </label>
                    </div>
                    <button className="btn">Ajouter une dépense</button>
                </form>
            </div >
        </div >
    )
}

export default AddColoc