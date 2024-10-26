"use client";
import axios from 'axios';
axios.defaults.withCredentials = true;
import { useRouter } from 'next/navigation';
import React, { useEffect, useState } from 'react'


const Companies = () => {
    const router = useRouter();
    const [companies, setCompanies] = useState([]);
    const [nextPage, setNextPage] = useState('');
    const [previousPage, setPreviousPage] = useState('');
    const [currentPage, setCurrentPage] = useState('');
    const [errorMessages, setErrorMessages] = useState('');
    const defaultUrl = 'http://localhost:8000/api/companies';

    const fetchCompanies = async (url) => {
        if (!url) {
            url = defaultUrl;
        }
        try {
            const response = await axios.get(url);
            const responseData = response.data;

            setCompanies(responseData.data);
            setCurrentPage(responseData.links.current);
            setPreviousPage(responseData.links.prev);
            setNextPage(responseData.links.next);
        } catch (error) {
            const message = error.response.data.message
            setErrorMessages(message);
        }
    }

    const clickPreivousPage = () => {
        fetchCompanies(previousPage);
    }

    const clickNextPage = () => {
        fetchCompanies(nextPage);
    }

    const clickDelete = async (id) => {
        if (!confirm('削除しますか？')) {
            return;
        }

        try {
            await axios.delete(`http://localhost:8000/api/companies/${id}`);

            // companiesの数が1つだった場合、前のページに戻る
            if (companies.length === 1) {
                fetchCompanies(previousPage);
                return;
            }

            // 一つ以上なら、そのままのページにとどまる
            fetchCompanies(currentPage);
        } catch (error) {
            const message = error.response.data.message
            setErrorMessages(message);
        }
    }

    useEffect(() => {
        fetchCompanies();
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
                        <th>会社名</th>
                        <th><button 
                                className="bg-blue-500 hover:bg-blue-600 text-white font-medium px-3 py-1 mx-1 font-semibold rounded my-5"
                                onClick={() => router.push(`/companies/create`)}
                            >
                                新規登録
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody className="bg-white">
                    {companies && companies.map((company) => (
                        <tr key={company.id} className="text-center border">
                            <td>{company.id}</td>
                            <td>{company.name}</td>
                            <td>
                                <button
                                    onClick={() => router.push(`/companies/edit/${company.id}`)}
                                    className="bg-blue-500 hover:bg-blue-600 text-white font-medium px-3 py-1 my-2 mx-1 font-semibold rounded"
                                >編集</button>
                                <button
                                    onClick={() => clickDelete(company.id)}
                                    className="bg-red-500 hover:bg-red-600 text-white font-medium px-3 py-1 my-2 mx-1 font-semibold rounded"
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

export default Companies