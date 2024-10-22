import React from 'react';

const BookForm = ({ onChange, errors }) => {
    return (
        <div id="book" className='pl-20'>
            <div className='form-group'>
                <label htmlFor="">Weight (Kg)</label>
                <input type="number" id="weight" min="0" step="0.1" name="weight" onChange={onChange} className='form-control' />
            </div>

            <p>Please, provide weight in Kg</p>
        </div>
    );
};

export default BookForm;