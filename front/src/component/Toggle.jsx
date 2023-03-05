import '../assets/css/components/toggle.css'

const Toggle = (props) => {

    const { isChecked, onToggle } = props;

    function handleChange() {
      onToggle();
    }

    return (
        <label className={`toggle ${isChecked ? 'on' : ''}`}>
            <input type="checkbox" checked={isChecked} onChange={handleChange}/>
            <span className="slider">
                <h3>Les dépenses</h3>
                <h3>L'équilibre</h3>
            </span> 
        </label>
    )
}

export default Toggle