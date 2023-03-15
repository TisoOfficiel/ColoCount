import React from 'react'
import Cookies from 'js-cookie';
import '../assets/css/components/equilibre.css'
const Equilibre = (props) => {
    const colocId = props.colocationInfo.colocation_id;
    const chargeInfo = props.chargeInfo;
    const colocationInfo = props.colocationInfo;
    const userInfo = props.userInfo;
    const equilibreInfo = props.equilibreInfo;
    const connectedId = props.connectedId;

    async function sendRepayment(paymasterId,beneficiaryId,amount){
        let jwtToken = Cookies.get('token');

        await fetch(`http://localhost:1501/mes_colocs/${colocId}/add_remboursement`, {
            method: 'POST',
            mode:"cors",
            credentials:"include",
            headers: new Headers({
                "Authorization": "Bearer " + jwtToken,
                "content-type": "application/x-www-form-urlencoded",
            }),
            body: new URLSearchParams({
                paymaster:JSON.stringify(paymasterId),
                beneficiary:JSON.stringify(beneficiaryId),
                amount:JSON.stringify(amount),
            })
        }).then(response => response.json())
        .then(data => {
            if(data.status === 'success'){
                window.location.reload();
            }
        });
    }
    return (
        <div className='macoloc-content'>
            <div className="header">
                <h2 className='macoloc-equilibre-title'>Équilibre des dépenses</h2>
                <h3 className='macoloc-equilibre-name-coloc'>{colocationInfo.colocation_name}</h3>
            </div>
            <div className="equilibre-container">
                <div className="user-amount-container">

                    {Object.keys(userInfo).map((key, index) => {
                        return (
                            <div key={index} className="user-card">
                                <div className='user-picture-profile'></div>
                                <h4 className='username'>
                                    {userInfo[key].user_username}
                                </h4>
                                <h4 className={`user_amount ${userInfo[key].user_amount >= 0 ? 'positive-amount' : 'negative-amount'}`}>
                                    {userInfo[key].user_amount} €
                                </h4>
                            </div>
                        );
                    })}
                </div>
                <div className="user-transaction-container">
                    <h4 className='repayment-title'>Qui rembourser ?</h4>
                    <div className="transaction-container">
                        {equilibreInfo.map((transaction_info, index) => (
                            <div className="transaction-row" key={index}>
                                <div className="transaction-paymaster">
                                    {transaction_info[0]['user_username']}  
                                </div>
                                <p>doit à</p>
                                <div className="transaction-beneficiary">
                                    {transaction_info[2]['user_username']}
                                </div>
                                <div className="transaction-amount">
                                    {transaction_info[1]}€
                                </div>
                                {connectedId === transaction_info[0]['user_id'] && (
                                    <button className='btn' onClick={() => sendRepayment(connectedId, transaction_info[2].user_id, transaction_info[1])}>Rembourser</button>
                                )}
                            </div>
                        ))}
                    </div>

                    {}
                </div>
            </div>
        </div>
    )
}

export default Equilibre