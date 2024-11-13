import React from 'react';

const BookForm = ({ onChange }) => {
    return (
        <div id="Book" className='pl-20'>
            <div className='form-group'>
                <label htmlFor="weight">Weight (Kg)</label>
                <input type="number" id="weight" min="0" step="0.1" name="weight" onChange={onChange} className='form-control' />
            </div>

            <p>Please, provide weight in Kg</p>
        </div>
    );
};

export default BookForm;