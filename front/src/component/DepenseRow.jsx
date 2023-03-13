import MoreVertical from '../assets/photos/svg/more-vertical.svg'
import '../assets/css/components/depense-row.css'
const DepenseRow = (props) => {

  const chargeInfo = props.charge[0];
  const paymasterInfo = props.charge[1];
  const participantInfo = props.charge[2];

  return (
    <div className="charge-container" key={props.datakey}>
    <h4 className="title-charge" data-chargeid={chargeInfo.charge_id}>{chargeInfo.charge_name}</h4>
    <p className="paymaster-charge" data-paymasterid={paymasterInfo.paymaster_id}>Payé par {paymasterInfo.paymaster_name}</p>
        <div className="left">
            <p className="amount-charge">{chargeInfo.charge_amount}€</p>
            <img src={MoreVertical} alt="more vertical" className='moreVertical' />
        </div>
    </div>
  )
}

export default DepenseRow