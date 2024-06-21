import "./default-layout.sass"
import React, {ReactNode} from "react";

type Props = {
    children: ReactNode
}
export default function DefaultLayout({children}: Props) {
    return (
        <div className="default-layout">
            {children}
        </div>
    )
}
