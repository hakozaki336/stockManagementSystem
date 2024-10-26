'use client'
import axios from "axios";
import { useRouter } from "next/navigation";
axios.defaults.withCredentials = true;
import { useState, useEffect } from "react";

const Edit = ({ params }) => {
    const router = useRouter();
    const [errorMessages, setErrorMessages] = useState('');
    const [name, setName] = useState('');

    const shouldDisableSubmitButton = (name) => {
        return !name;
    }

    const isButtonDisabled = shouldDisableSubmitButton(name);

    const changeName = (event) => {
        setName(event.target.value);
        shouldDisableSubmitButton();
    }

    const getCompany = async () => {
        try {
            const response = await axios.get(`http://localhost:8000/api/companies/${params.id}`);
            const responseData = response.data;

            setName(responseData.name);
        } catch (error) {
            const message = error.response.data.message
            setErrorMessages(message);
        }
    }

    const changeCompany = async () => {
        try {
            await axios.put(`http://localhost:8000/api/companies/${params.id}`, 
                {
                    name: name,
                }
            );
            router.push(`/companies`)
        } catch (error) {
            const message = error.response.data.message
            setErrorMessages(message);
        }
    }

    useEffect(() => {
        getCompany();
    }, [params.id]);

  return (
    <div className="bg-white mx-5 my-5">
            {errorMessages && (
                <div className="bg-red-500 text-white text-sm font-bold p-2 rounded">{errorMessages}</div>
            )}
        <h1 className="p-3 text-2xl font-semibold border-b">会社を編集してください</h1>
        <div className="px-3 ">
            <div className="my-5">
                <div className="flex m-3">
                    <label className="text-xl mr-3 ">会社名:</label>
                    <input type="text" name="name"
                        className="w-64"
                        onChange={changeName}
                        value={name}
                    />
                </div>
            </div>
            <button
                className="bg-blue-500 hover:bg-blue-600 text-white font-medium px-3 py-1 mb-2 mx-1 font-semibold rounded disabled:cursor-not-allowed disabled:bg-gray-300"
                onClick={changeCompany}
                disabled={isButtonDisabled}
            >
                更新
            </button>
        </div>
    </div>
  )
}

export default Edit