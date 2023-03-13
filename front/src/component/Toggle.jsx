import '../assets/css/components/toggle.css'

const Toggle = (props) => {

    const { depenseChecked, onToggle } = props;

    function handleChange() {
      onToggle();
    }

    return (
        <label className={`toggle ${depenseChecked ? 'on' : ''}`}>
            <input type="checkbox" checked={depenseChecked} onChange={handleChange}/>
            <span className="slider">
                <h3>Les dépenses</h3>
                <h3>L'équilibre</h3>
            </span> 
        </label>
    )
}

export default Toggle