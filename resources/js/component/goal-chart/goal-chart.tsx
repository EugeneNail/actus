import "./goal-chart.sass"
import React, {useEffect, useRef} from "react";

type Props = {
    values: {
        plain: number
        percent: number
    }[]
    period: string
}

export default function GoalChart({values, period}: Props) {
    const canvasRef = useRef(null);

    useEffect(() => {
        const canvas = canvasRef.current;
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        const paddingY = 40;
        const paddingX = 15;

        const stepsY = 5;
        let stepY = (canvas.height - paddingY * 2) / stepsY;

        for (let i = 0; i <= stepsY; i++) {
            ctx.beginPath();
            ctx.moveTo(0, stepY * i + paddingY);
            ctx.lineTo(canvas.width - paddingX, stepY * i + paddingY);
            ctx.strokeStyle = '#bbb';
            ctx.lineWidth = 1;
            ctx.stroke();
        }

        const stepX = (canvas.width - paddingX * 2) / values.length
        stepY = (canvas.height - paddingY * 2 ) / 100

        for (let i = 0; i < values.length -1; i++) {
            drawLine(canvas, ctx, paddingY, paddingX, i, i+1, stepX, stepY)
        }

        drawLine(canvas, ctx, paddingY, paddingX, values.length - 1, values.length - 1, stepX, stepY)
    }, []);


    function drawLine(canvas, ctx, paddingY: number, paddingX: number, i0: number, i1: number, stepX: number, stepY: number) {
        const x0 = i0 * stepX + paddingX;
        const y0 = (canvas.height - paddingY - stepY * values[i0].percent);
        const x1 = (i1) * stepX + paddingX;
        const y1 = (canvas.height - paddingY - stepY * values[i1].percent);

        const stepXOffset = stepX / 4;
        const x01 = x0 + stepXOffset;
        const y01 = y0 == y1 ? y1 : (y0 > y1 ? y0 - stepXOffset : y0 + stepXOffset);
        const x11 = x1 - stepXOffset;
        const y11 = y0 == y1 ? y1 : (y0 > y1 ? y1 + stepXOffset : y1 - stepXOffset);

        ctx.beginPath();
        ctx.moveTo(x0, y0);

        ctx.lineTo(x01, y01);
        ctx.lineTo(x11, y11);
        ctx.lineTo(x1, y1);

        ctx.strokeStyle = '#8CB369';
        ctx.lineWidth = period == 'month' ? 3 : 2;
        ctx.stroke();

        ctx.lineTo(x1, canvas.height - paddingY);
        ctx.lineTo(x0, canvas.height - paddingY);
        ctx.lineTo(x0, y0);
        ctx.fillStyle = '#8CB36999';
        ctx.fill();

        if (period == 'month') {
            ctx.beginPath();
            ctx.arc(x0, y0, 5, 0, 2 * Math.PI);
            ctx.fillStyle = '#8CB369';
            ctx.fill();

            ctx.font = '25px Arial';
            ctx.fillStyle = '#777';
            ctx.fillText(values[i0].plain, x0 - (values[i0].plain < 10 ? 7 : 14), y0 - 20);
        }
    }


    return (
        <div className="goal-chart">
            <p className="goal-chart__label">Goal Chart</p>
            <canvas className="goal-chart__chart" ref={canvasRef} width={1000} height={500}/>
        </div>
    );
}
