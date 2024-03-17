export default function Comment({comment, type}) {

    return (
        <div className={`inline-flex gap-0 ${type === 0 ? 'justify-start' : 'justify-end'}`}>

            <div className="flex flex-col justify-end max-w-fit" style={{order:type*2}}>
                <svg width="27" height="53" viewBox="0 0 26 53" fill="none" xmlns="http://www.w3.org/2000/svg">
                    {type === 0 ?
                        <path d="M26.217 53V17.5C24.7949 32.5961 23.6027 38.0965 14.4766 44.5L0.5 53H26.217Z"
                              fill="#2B2A2A"/>

                        :
                        <path d="M8.2016e-05 53V17.5C1.42215 32.5961 2.61438 38.0965 11.7404 44.5L25.717 53H8.2016e-05Z"
                              fill="#2B2A2A"/>
                    }
                </svg>
            </div>


            <div
                className={`w-[480px] h-fit rounded-3xl ${type === 0 ? 'rounded-bl-none' : 'rounded-br-none'} flex flex-col gap-1 text-white bg-[#2B2A2A] p-4`}
            style={{order:1}}>

                <div className={'inline-flex justify-between shadow-2xl shadow-black z-10'}>
                    <span>{comment.author.name}</span>
                    <span>{comment.created_at}</span>
                </div>
                <hr />
                <span className={'text-wrap'}>
                    {comment.content}
                </span>

            </div>

        </div>
    )
}
