"use client";
import axios from 'axios';
axios.defaults.withCredentials = true;
import React, { useEffect, useState } from 'react'


const Products = () => {
    const [products, setProducts] = useState([]);
    const [nextPage, setNextPage] = useState('');
    const [previousPage, setPreviousPage] = useState('');
    const [currentPage, setCurrentPage] = useState('');
    const [errorMessages, setErrorMessages] = useState('');
    const defaultUrl = 'http://localhost:8000/api/orders';

    const fetchProducts = async (url) => {
      if (!url) {
          url = defaultUrl;
      }
    try {
        const response = await axios.get(url);
        const responseData = response.data;

        setProducts(responseData.data);
        setCurrentPage(responseData.links.current);
        setPreviousPage(responseData.links.prev);
        setNextPage(responseData.links.next);
    } catch (error) {
        const message = error.response.data.message
        setErrorMessages(message);
    }
    }

    const clickPreivousPage = () => {
        fetchProducts(previousPage);
    }

    const clickNextPage = () => {
        fetchProducts(nextPage);
    }

    const clickDelete = async (id) => {
        if (!confirm('削除しますか？')) {
            return;
        }

        try {
            await axios.delete(`http://localhost:8000/api/orders/${id}`);

            // productの数が1つだった場合、前のページに戻る
            if (products.length === 1) {
                fetchProducts(previousPage);
                return;
            }

            // 一つ以上なら、そのままのページにとどまる
            fetchProducts(currentPage);
        } catch (error) {
            const message = error.response.data.message
            setErrorMessages(message);
        }
    }

    useEffect(() => {
        fetchProducts();
    } ,[]);

    return (
        <div className="m-5">
            {errorMessages && (
                <div className="bg-red-500 text-white text-sm font-bold p-2 rounded">{errorMessages}</div>
            )}
            <table className="min-w-full mt-10">
                <thead className="">
                    <tr className="">
                        <th>ID</th>
                        <th>企業名</th>
                        <th>商品名</th>
                        <th>価格</th>
                        <th>注文数</th>
                        <th>注文日</th>
                        <th>出荷・未出荷</th>
                        <th><button className="bg-blue-500 hover:bg-blue-600 text-white font-medium px-3 py-1 my-2 mx-1 font-semibold rounded my-5">新規登録</button></th>
                    </tr>
                </thead>
                <tbody className="bg-white">
                    {products && products.map((product) => (
                        <tr key={product.id} className="text-center border">
                            <td>{product.id}</td>
                            <td>{product.company_name}</td>
                            <td>{product.product_name}</td>
                            <td>{product.price}</td>
                            <td>{product.order_count}</td>
                            <td>{product.order_date}</td>
                            <td>{product.dispatched}</td>
                            <td>
                                <button className="bg-blue-700 hover:bg-blue-800 text-white font-medium px-3 py-1 my-2 mx-1 font-semibold rounded">編集</button>
                                <button
                                    onClick={() => clickDelete(product.id)}
                                    className="bg-red-700 hover:bg-red-800 text-white font-medium px-3 py-1 my-2 mx-1 font-semibold rounded"
                                >削除</button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
            <div className="flex justify-center py-5">
                {previousPage && (
                    <a 
                        className="flex items-center justify-center px-4 font-medium hover:text-gray-600"
                        onClick={clickPreivousPage}
                    >
                        <svg className="w-3.5 h-3.5 me-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 5H1m0 0 4 4M1 5l4-4"/>
                        </svg>
                        Previous
                    </a>
                )}
                {nextPage && (
                    <a 
                        className="flex items-center justify-center px-4 font-medium hover:text-gray-600"
                        onClick={clickNextPage}
                    >
                        Next
                        <svg className="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                        </svg>
                    </a>
                )}
            </div>
        </div>
    )
}

export default Products