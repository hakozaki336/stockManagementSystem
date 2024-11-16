'use client'
import axios from "axios";
import { useRouter } from "next/navigation";
axios.defaults.withCredentials = true;
import { useState } from "react";


const Create = () => {
    const router = useRouter();
    const [errorMessages, setErrorMessages] = useState('');
    const [name, setName] = useState('');
    const [price, setPrice] = useState(0);
    const [stock, setStock] = useState(0);
    const [area, setArea] = useState('');
    const [stockManagemntType, setStockManagemntType] = useState('');

    const shouldDisableSubmitButton = (name, price, stock, area, stockManagemntType) => {
        const isCompanyEmpty = !name;
        const isProductEmpty = !price;
        const isStockInvalid = stock === '' || parseInt(stock) < 1;
        const isAreaEmpty = !area;
        const isStockManagemntTypeEmpty = !stockManagemntType;

        return (isCompanyEmpty || isProductEmpty || isStockInvalid || isAreaEmpty || isStockManagemntTypeEmpty);
    }

    const isButtonDisabled = shouldDisableSubmitButton(name, price, stock, area, stockManagemntType);

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

    const changeArea = (event) => {
        setArea(event.target.value);
        shouldDisableSubmitButton();
    }

    const changeStockManagemntType = (event) => {
        setStockManagemntType(event.target.value);
        shouldDisableSubmitButton();
    }

    const createProduct = async () => {
        try {
            await axios.post('http://localhost:8000/api/products', 
                {
                    name: name,
                    price: price,
                    stock: stock,
                    area: area,
                    stock_management_type: stockManagemntType,
                }
            );
            router.push(`/products`)
        } catch (error) {
            const message = error.response.data.message
            setErrorMessages(message);
        }
    }

  return (
    <div className="bg-white mx-5 my-5">
            {errorMessages && (
                <div className="bg-red-500 text-white text-sm font-bold p-2 rounded">{errorMessages}</div>
            )}
        <h1 className="p-3 text-2xl font-semibold border-b">商品を登録してください</h1>
        <div className="px-3 ">
            <div className="my-5">
                <div className="flex m-3">
                    <label className="text-xl mr-3 ">商品名　　　:</label>
                    <input type="text" name="name"
                        className="w-64"
                        onChange={changeName}
                    />
                </div>
                <div className="flex m-3">
                    <label className="text-xl mr-3">値段　　　　:</label>
                    <input type="number" name="price"
                        className="w-64"
                        onChange={changePrice}
                        min="1"
                    />
                </div>
                <div className="flex m-3">
                    <label className="text-xl mr-3">在庫数　　　:</label>
                    <input type="number" name="price"
                        className="w-64"
                        onChange={changeStock}
                        min="1"
                    />
                </div>
                <div className="flex m-3">
                    <label className="text-xl mr-3 ">保存エリア　:</label>
                    <input type="text" name="area"
                        className="w-64"
                        onChange={changeArea} 
                    />
                </div>
                <div className="flex m-3">
                    <label className="text-xl mr-3 ">在庫管理方法:</label>
                    <select name="company_name" className="w-64"
                        onChange={changeStockManagemntType}
                    >
                        <option value="">選択してください</option>
                        <option value="FIFO">FIFO</option>
                        <option value="LIFO">LIFO</option>
                    </select>
                </div>
            </div>
            <button
                className="bg-blue-500 hover:bg-blue-600 text-white font-medium px-3 py-1 mb-2 mx-1 font-semibold rounded disabled:cursor-not-allowed disabled:bg-gray-300"
                onClick={createProduct}
                disabled={isButtonDisabled}
            >
                追加
            </button>
        </div>
    </div>
  )
}

export default Create