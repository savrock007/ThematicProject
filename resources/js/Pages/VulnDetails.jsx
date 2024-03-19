import {Head} from "@inertiajs/react";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {FaArrowLeft} from "react-icons/fa";
import {useState} from "react";
import Comment from "@/Components/Comment";


export default function VulnDetails({auth, vuln}) {
    const [tab, setTab] = useState('overview');
    vuln = Object.values(vuln)[0];
    const linear = 'linear-gradient(to right, #2B2A2A 0%, #A7A7A7 50%, #2B2A2A 100%) 10 / 1 / 1 stretch'
    return (
        <AuthenticatedLayout user={auth.user}>
            <Head title="VulnDetails"/>
            <div className="flex flex-col items-center justify-center p-16">
                <div className="top_nav flex flex-row p-4 justify-center items-center gap-10">
                    <a className="text-white absolute left-60 flex flex-row items-center justify-center gap-3"
                       href="/vulns"><FaArrowLeft/>Back</a>
                    <div
                        className="tabs flex flex-row border-b-[1px] border-[#2B2A2A] items-center justify-between gap-10">
                        <button className="tab1 text-white px-6 border-solid border-b-2"
                                onClick={() => setTab('overview')}
                                style={tab === 'overview' ? {borderImage: linear} : {borderColor: "transparent"}}>
                            Overview
                        </button>
                        <button className="tab2 text-white px-6 border-solid border-b-2"
                                onClick={() => setTab('comments')}
                                style={tab === 'comments' ? {borderImage: linear} : {borderColor: "transparent"}}>
                            Comments
                        </button>
                    </div>
                </div>


                <div className="overview w-4/5 rounded-2xl bg-[#2B2A2A] p-6"
                     style={tab === 'overview' ? {display: "flex"} : {display: 'none'}}>
                    <div className="left flex flex-col w-1/2 gap-8">
                        <div className="title flex flex-col gap-2">
                            <p className="text-white text-2xl">{vuln.title}</p>
                            <p className="text-[#949494]">{vuln.severity?.title} severity</p>
                            <div className="badges flex flex-row gap-4">
                                <div className="severity_badge w-fit text-white bg-[#FF0000] rounded-2xl px-2 py-1">
                                    <p className="text-md">Severity: {vuln.severity?.title}</p>
                                </div>

                                <div className="posted_badge w-fit text-white bg-[#0038FF] rounded-2xl px-2 py-1">
                                    <p className="text-md">Posted
                                        at: {vuln.created_at ? vuln.created_at : "unknown"}</p>
                                </div>

                            </div>
                        </div>

                        <div className="description flex flex-col gap-2">
                            <p className="text-[#D0CCCC] text-xl">Description</p>
                            <p className="text-white text-lg">{vuln.description}</p>
                        </div>
                        <div className="description flex flex-col gap-2">
                            <p className="text-[#D0CCCC] text-xl">Steps to reproduce:</p>
                            <p className="text-white text-lg">{vuln.description}</p>
                        </div>

                    </div>

                    <div className="right flex flex-col w-1/2 gap-8 items-center">
                        <div className="affected_assets flex flex-col gap-2 w-1/2">
                            <p className="text-[#D0CCCC] text-xl">Affected assets:</p>
                            <p className="text-white text-lg">{vuln.description}</p>
                        </div>
                        <div className="dev_assigned w-full flex flex-col items-center">
                            <p className="w-fit text-white text-xl">Developer assigned: </p>
                            <p className="w-fit text-[#7B15FD] text-lg">{vuln.developer?.name}{vuln.developer?.id === auth.user.id ? " (You)" : ''}</p>
                        </div>
                        {vuln.tester &&
                        <div className="dev_assigned w-full flex flex-col items-center">
                            <p className="w-fit text-white text-xl">Tester assigned: </p>
                            <p className="w-fit text-[#7B15FD] text-lg">{vuln.tester?.name} {vuln.tester?.id === auth.user.id ? " (You)" : ''}</p>
                        </div>
                        }


                        <div className="status element flex flex-col gap-3">
                            <div className="bar flex flex-row justify-center">
                                <div
                                    style={(vuln.status?.id > 0) ? {backgroundColor: "white"} : {backgroundColor: "transparent"}}
                                    className="sub_bar border border-[#909090] w-[60px] h-[15px] rounded-full"></div>
                                <div
                                    style={(vuln.status?.id > 1) ? {backgroundColor: "white"} : {backgroundColor: "transparent"}}
                                    className="sub_bar border border-[#909090] w-[60px] h-[15px] rounded-full"></div>
                                <div
                                    style={(vuln.status?.id > 2) ? {backgroundColor: "white"} : {backgroundColor: "transparent"}}
                                    className="sub_bar border border-[#909090] w-[60px] h-[15px] rounded-full"></div>
                                <div
                                    style={(vuln.status?.id > 3) ? {backgroundColor: "white"} : {backgroundColor: "transparent"}}
                                    className="sub_bar border border-[#909090] w-[60px] h-[15px] rounded-full"></div>

                            </div>
                            <div className="flex justify-center">
                                <p className="text-white">Status: {vuln.status?.title ?? 'NaN'}</p>
                            </div>
                        </div>

                    </div>

                </div>
                <div className={'flex-col w-[80%] gap-8'}
                     style={tab === 'comments' ? {display: "flex"} : {display: 'none'}}>
                    {
                        vuln.comments.map((comment) =>
                            (
                                <Comment key={comment.id} comment={comment} type={comment.author.id === auth.user.id ? 1 : 0}/>
                            )
                        )

                    }
                </div>

            </div>
        </AuthenticatedLayout>
    )
}
