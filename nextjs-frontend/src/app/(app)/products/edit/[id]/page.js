'use client'
import axios from "axios";
import { useRouter } from "next/navigation";
axios.defaults.withCredentials = true;
import { useState, useEffect } from "react";

const Edit = ({ params }) => {
    const router = useRouter();
    const [errorMessages, setErrorMessages] = useState('');
    const [name, setName] = useState('');
    const [price, setPrice] = useState(0);
    const [stock, setStock] = useState(0);

    const shouldDisableSubmitButton = (name, price, stock) => {
        const isCompanyEmpty = !name;
        const isProductEmpty = !price;
        const isStockInvalid = stock === '' || parseInt(stock) < 1;

        return (isCompanyEmpty || isProductEmpty || isStockInvalid);
    }

    const isButtonDisabled = shouldDisableSubmitButton(name, price, stock);

    const changeName = (event) => {
        setName(event.target.value);
        shouldDisableSubmitButton();
    }

    const changePrice = (event) => {
        setPrice(event.target.value);
        shouldDisableSubmitButton();
    }

    const changeStock = (event) => {
        setStock(event.target.value);
        shouldDisableSubmitButton();

    }

    const getProduct = async () => {
        try {
            const response = await axios.get(`http://localhost:8000/api/products/${params.id}`);
            const responseData = response.data;

            setName(responseData.name);
            setPrice(responseData.price);
            setStock(responseData.stock);
        } catch (error) {
            const message = error.response.data.message
            setErrorMessages(message);
        }
    }

    const changeProduct = async () => {
        try {
            await axios.put(`http://localhost:8000/api/products/${params.id}`, 
                {
                    name: name,
                    price: price,
                    stock: stock
                }
            );
            router.push(`/products`)
        } catch (error) {
            const message = error.response.data.message
            setErrorMessages(message);
        }
    }

    useEffect(() => {
        getProduct();
    }, [params.id]);

  return (
    <div className="bg-white mx-5 my-5">
            {errorMessages && (
                <div className="bg-red-500 text-white text-sm font-bold p-2 rounded">{errorMessages}</div>
            )}
        <h1 className="p-3 text-2xl font-semibold border-b">商品を編集してください</h1>
        <div className="px-3 ">
            <div className="my-5">
                <div className="flex m-3">
                    <label className="text-xl mr-3 ">商品名:</label>
                    <input type="text" name="name"
                        className="w-64"
                        onChange={changeName}
                        value={name}
                    />
                </div>
                <div className="flex m-3">
                    <label className="text-xl mr-3">値段　:</label>
                    <input type="number" name="price"
                        className="w-64"
                        onChange={changePrice}
                        min="1"
                        value={price}
                    />
                </div>
                <div className="flex m-3">
                    <label className="text-xl mr-3">在庫数:</label>
                    <input type="number" name="price"
                        className="w-64"
                        onChange={changeStock}
                        min="1"
                        value={stock}
                    />
                </div>
            </div>
            <button
                className="bg-blue-500 hover:bg-blue-600 text-white font-medium px-3 py-1 mb-2 mx-1 font-semibold rounded disabled:cursor-not-allowed disabled:bg-gray-300"
                onClick={changeProduct}
                disabled={isButtonDisabled}
            >
                更新
            </button>
        </div>
    </div>
  )
}

export default Edit