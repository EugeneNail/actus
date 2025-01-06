import React, {useEffect, useRef} from "react";
import {ColorCode} from "../../model/color-code";
import {Color} from "../../model/color";

type Props = {
    values: number[]
    color: Color
    step: number
    decimalPlaces?: number
    className?: string
};

export default function LineChart({className, values, color, step, decimalPlaces = 0}: Props) {
    const canvasRef = useRef(null);


    useEffect(() => {
        const canvas = canvasRef.current;
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        const padding = 30
        const marginLeft = 100
        const minY = Math.min(...values.filter(value => value != -1))
        const maxY = Math.max(...values.filter(value => value != -1))
        const stepY = (canvas.height - padding * 2) / (maxY - minY)
        const stepX = (canvas.width - marginLeft) / (values.length - 1);
        const valueDifference = maxY - minY
        const remainder = minY % step
        console.log(minY + ' ' + remainder)
        const rows = Math.floor(valueDifference / step)

        const lineStep = (canvas.height - padding * 2)  / rows

        for (let i = 0; i < rows + 1; i++) {
            ctx.beginPath()
            const y = canvas.height - (i + remainder) * lineStep - padding
            ctx.font = '30px Arial'
            ctx.fillStyle = '#999'
            ctx.textAlign = 'end'
            ctx.fillText((minY + step * i - remainder).toFixed(decimalPlaces), marginLeft - 40, y + 8)
            ctx.moveTo(marginLeft - 20, y)
            ctx.lineTo(canvas.width, y)
            ctx.strokeStyle = '#bbb'
            ctx.lineWidth = 1
            ctx.stroke()
        }

        for (let i = 0; i < values.length - 1; i++) {
            if (values[i] == -1) {
                continue;
            }

            const x0 = i * stepX + marginLeft
            const y0 = (maxY - values[i]) * stepY + padding
            const x1 = (i + 1) * stepX + marginLeft
            const y1 = (maxY - values[i + 1]) * stepY + padding

            ctx.beginPath()
            let radius = (i + 1) % 10 == 0 ? 12 : 8
            ctx.arc(x0, y0, radius, 0, 2 * Math.PI)
            ctx.fillStyle = ColorCode[color]
            ctx.fill()

            if (values[i+1] == -1) {
                continue;
            }

            ctx.beginPath()
            ctx.moveTo(x0, y0)
            ctx.lineTo(x1, y1)
            ctx.strokeStyle = ColorCode[color]
            ctx.lineWidth = 3
            ctx.stroke()

            ctx.beginPath()
            radius = (i + 2) % 10 == 0 ? 12 : 8
            ctx.arc(x1, y1, radius, 0, 2 * Math.PI)
            ctx.fillStyle = ColorCode[color]
            ctx.fill()
        }
    }, []);

    return (
        <canvas className={className} height={500} width={1000} ref={canvasRef}/>
    )
}
