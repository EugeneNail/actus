import React, {ReactNode} from "react";

type Props = {
    children: ReactNode
}
export default function GuestLayout({children}: Props) {
    return (
        <div className="guest-layout">
            {children}
        </div>
    )
}
