export default function VulnCard({vuln}){
    return(
        <div className="bg-[#2B2A2A] h-[400px] w-[90%] p-6 rounded-lg flex flex-row">
            <div className="left flex flex-col w-1/2 gap-8">
                <div className="title">
                    <p className="text-white text-2xl">{vuln.title}</p>
                    <p className="text-[#949494]">{vuln.severity ?? 'nothing here yet fix it'}</p>

                </div>
                <p className="text-white text-lg">{vuln.description}</p>
                <div className="description">

                </div>
                <div className="badges flex flex-col gap-4">
                    <div className="severity_badge w-fit text-white bg-[#FF0000] rounded-2xl px-4 py-1">
                        <p>Severity: {vuln.severiy ?? "unknown"}</p>
                    </div>

                    <div className="posted_badge w-fit text-white bg-[#0038FF] rounded-2xl px-4 py-1">
                        <p>Posted_at: {vuln.created_at ? vuln.created_at.slice(0,10) : "unknown"}</p>
                    </div>

                </div>
            </div>

            <div className="right flex flex-col w-1/2">


            </div>
        </div>


    )
}
