export default function VulnCard({vuln}) {
    return (
        <div className="bg-[#2B2A2A] h-[400px] w-[90%] p-10 rounded-3xl flex flex-row">
            <div className="left flex flex-col w-1/2 gap-8">
                <div className="title">
                    <p className="text-white text-2xl">{vuln.title}</p>
                    <p className="text-[#949494]">{vuln.severity?.title} severity</p>

                </div>
                <div className="description">
                    <p className="text-white text-lg">{vuln.description}</p>
                </div>
                <div className="badges flex flex-col gap-4">
                    <div className="severity_badge w-fit text-white bg-[#FF0000] rounded-2xl px-4 py-1">
                        <p>Severity: {vuln.severity?.title}</p>
                    </div>

                    <div className="posted_badge w-fit text-white bg-[#0038FF] rounded-2xl px-4 py-1">
                        <p>Posted at: {vuln.created_at ? vuln.created_at : "unknown"}</p>
                    </div>

                </div>
            </div>

            <div className="right flex flex-col w-1/2 gap-8 items-center">
                <div className="dev_assigned flex flex-col items-center">
                    <p className="w-fit text-white text-xl">Developer assigned: </p>
                    <p className="w-fit text-[#7B15FD] text-lg">{vuln.developer?.name}</p>
                </div>

                <div className="status element flex flex-col gap-3">
                    <div className="bar flex flex-row justify-center">
                        {Array(4).fill().map((_, index) => (
                            <div
                                key={index}
                                style={{
                                    backgroundColor: (vuln.status?.id > index) ? ['red', 'yellow', 'blue', 'green'][index] : "transparent"
                                }}
                                className="sub_bar border border-[#909090] w-[60px] h-[15px] rounded-full">
                            </div>
                        ))}
                    </div>
                    <div className="flex justify-center">
                        <p className="text-white">Status: {vuln.status?.title ?? 'NaN'}</p>
                    </div>
                </div>


                <a href={`/vulns/${vuln.id}`} className="py-2 px-10 text-white rounded-3xl bg-[#5D00D2] w-fit" >View Details</a>

            </div>
        </div>


    )
}
