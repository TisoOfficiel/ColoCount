import React from 'react'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faXmark } from "@fortawesome/free-solid-svg-icons"
import '../../assets/css/components/modal/single-charge-info.css'

const SingleInfoCharge = (props) => {
    const title = props.infoSingleCharge.title;
    const paymaster = props.infoSingleCharge.paymaster;
    const participants = props.infoSingleCharge.participant;
    const amount = props.infoSingleCharge.amount;
    const amountPerPersonne = props.infoSingleCharge.amountPerPersonne;
    return (
        <div className="modal-background">
            <div className="modal-container modal-SingleInfo">
                <FontAwesomeIcon className="close-icon" icon={faXmark} onClick={props.onClose}></FontAwesomeIcon>
                <h2 className="title">{title}</h2>
                <div className="content-infoSinglePage">
                    <div className="left-infoSinglePage">
                        <p className='depense'>{amount}€</p>
                    </div>
                    <div className="right-infoSinglePage">
                        <div className="head-infoSinglePage">
                            <p className="content-infoSinglePage">Payé par {paymaster}</p>
                        </div>
                        <div className="body-infoSinglePage">
                            {participants.map(participant => (
                                <div key={participant} className="participant-container">
                                    <p>{participant}</p>
                                    <p className='amount-per-personne-content'>{amountPerPersonne}€</p>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default SingleInfoCharge