import React from 'react'
import '../assets/css/components/equilibre.css'
const Equilibre = (props) => {
    const chargeInfo = props.chargeInfo;
    const colocationInfo = props.colocationInfo;
    const userInfo = props.userInfo;
    const equilibreInfo = props.equilibreInfo;
    console.log(userInfo);
    console.log(props);
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
                        {equilibreInfo.map(transaction_info => (
                            <div className="transaction-row">
                                <div className="transaction-paymaster">
                                    {transaction_info[0]}
                                </div>
                                <p>doit à</p>
                                <div className="transaction-beneficiary">
                                    {transaction_info[2]}
                                </div>
                                <div className="transaction-amount">
                                    {transaction_info[1]}€
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </div>
    )
}

export default Equilibre