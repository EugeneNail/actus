import "./mood-chart.sass"
import React, {useEffect, useRef} from "react";

type Props = {
    values: number[]
    period: string
}

export default function MoodChart({values, period}: Props) {
    const canvasRef = useRef(null);
    const colors: {[key:number]: string} = {
        1: '#D33F49',
        2: '#FE5D26',
        3: '#4381C1',
        4: '#FFB140',
        5: '#8CB369',
    };

    useEffect(() => {
        const canvas = canvasRef.current;
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        const paddingY = 35;
        const paddingX = 15;

        const stepsY = 4;
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
        stepY = (canvas.height - paddingY * 2 ) / 4

        for (let i = 0; i < values.length -1; i++) {
            drawLine(canvas, ctx, paddingY, paddingX, i, i+1, stepX, stepY)
        }

        drawLine(canvas, ctx, paddingY, paddingX, values.length - 1, values.length - 1, stepX, stepY)
    }, []);


    function drawLine(canvas, ctx, paddingY: number, paddingX: number, i0: number, i1: number, stepX: number, stepY: number) {
        const x0 = i0 * stepX + paddingX;
        const y0 = (canvas.height - paddingY - stepY * (values[i0] - 1));
        const x1 = (i1) * stepX + paddingX;
        const y1 = (canvas.height - paddingY - stepY * (values[i1] - 1));

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

        ctx.strokeStyle = '#4381C1';
        ctx.lineWidth = period == 'month' ? 3 : 2;
        ctx.stroke();

        ctx.lineTo(x1, canvas.height - paddingY);
        ctx.lineTo(x0, canvas.height - paddingY);
        ctx.lineTo(x0, y0);

        ctx.fillStyle = '#4381C199';
        ctx.fill();

        if (period == 'month') {
            ctx.beginPath();
            ctx.arc(x0, y0, 5, 0, 2 * Math.PI);
            ctx.fillStyle = colors[values[i0]];
            ctx.fill();
        }
    }


    return (
        <div className="mood-chart">
            <p className="mood-chart__label">Mood Chart</p>
            <canvas className="mood-chart__chart" ref={canvasRef} width={1000} height={500}/>
        </div>
    );
}
