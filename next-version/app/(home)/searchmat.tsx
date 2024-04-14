"use client";

async function handleSubmit(formData: FormData) {
    const lib = formData.get("lib_search");
    const value = formData.get("user_search");

    location.href = "/mat/search?lib=" + lib + "&value=" + value;
}

export default function Searchmat(props){
    return(
        <form action={handleSubmit}>
            <div className="search">
                <select id="s1" name="lib_search">
                    {props.option}
                </select>
                <input type="text" name="user_search" id="id_search" placeholder="도서 이름을 입력해주세요." />
                <button type="submit" className="btn btn-outline-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                    </svg>
                </button>
            </div>
        </form>
    )
}