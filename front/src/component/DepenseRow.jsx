import MoreVertical from '../assets/photos/svg/more-vertical.svg'
import '../assets/css/components/depense-row.css'
import Cookies from 'js-cookie';
import { useState } from 'react';
import SingleInfoCharge from './modal/SingleInfoCharge';

const DepenseRow = (props) => {

  const chargeInfo = props.charge[0];
  const paymasterInfo = props.charge[1];
  const [infoSingleCharge,setInfoSingleCharge] = useState({});
  const [openSingleChargeModal,setOpentSingleChargeModal] = useState(false);
  // const participantInfo = props.charge[2];
  function handleCloseModalSingleCharge() {
    setOpentSingleChargeModal(false);
  }

  async function openSeeMore(chargeId) {
      let jwtToken = Cookies.get('token');
      let charge_id = chargeId;
      const colocId = props.colocationInfo.colocation_id;

      await fetch(`http://localhost:1501/mes_colocs/${colocId}/get_charge_info/${charge_id}`, {
          method: 'GET',
          mode:"cors",
          credentials:"include",
          headers: new Headers({
              "Authorization": "Bearer " + jwtToken,
              "content-type": "application/x-www-form-urlencoded",
          }),
      }).then(response => response.json())
      .then(data => {
        setInfoSingleCharge(data.infoSingleCharge);
          if(data.status === 'success'){
            setOpentSingleChargeModal(true);
          }
      });
  }
  
  return (

    

    <div className="charge-container" key={props.datakey} data-chargeid={chargeInfo.charge_id}>
      {openSingleChargeModal &&(
        <SingleInfoCharge infoSingleCharge={infoSingleCharge} onClose={handleCloseModalSingleCharge}/>
      )}
      <h4 className="title-charge">{chargeInfo.charge_name}</h4>
      <p className="paymaster-charge" data-paymasterid={paymasterInfo.paymaster_id}>Payé par {paymasterInfo.paymaster_name}</p>
      <div className="left">
          <p className="amount-charge">{chargeInfo.charge_amount}€</p>
          <div className="image-container">
            <img src={MoreVertical} alt="more vertical" className='moreVertical' />
            <div className="option-container">            
              <button className='more-content' onClick={() => openSeeMore(chargeInfo.charge_id)}>Voir plus</button>
            </div>
          </div>
      </div>
    </div>
  )
}

export default DepenseRow