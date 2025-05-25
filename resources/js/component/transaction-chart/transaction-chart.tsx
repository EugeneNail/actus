import "./transaction-chart.sass"
import React, {useEffect, useRef, useState} from "react";
import Chart from "@/model/transaction/chart";
import ChartNode from "@/model/transaction/chart-node";
import FlowModel from "@/model/transaction/flow";
import Flow from "@/component/transaction/flow/flow";

type Props = {
    scales: number[]
    main: Chart
    compared: Chart,
    flow: FlowModel

}

type BreakPoint = {
    node: ChartNode,
    index: number,
    x0: number,
    x1: number,
    y: number
}

export default function TransactionChart({scales, main, compared, flow}: Props) {
    const [currentBreakPoint, setCurrentBreakPoint] = useState<BreakPoint>(null)

    const canvasRef = useRef(null);
    const tempCanvasRef = useRef(null);

    const paddingY = 40;
    const xLeft = 15;
    const xRight = 75;
    const stepsY = 3;
    const breakPoints: BreakPoint[] = [];

    let stepX = 0
    let stepY = 0

    function getContext() {
        return canvasRef.current.getContext('2d')
    }


    useEffect(() => {
        const canvas = canvasRef.current;
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        stepX = (canvas.width - xLeft - xRight) / 31
        stepY = (canvas.height - paddingY * 2) / 100

        defineBreakPoints()
        drawScales()


        for (let i = 0; i < compared.nodes.length - 1; i++) {
            drawLine(compared.nodes, '#E2E2E2', i, i + 1)
        }

        for (let i = 0; i < main.nodes.length - 1; i++) {
            drawLine(main.nodes, '#D33F49', i, i + 1)
        }

        const finalX = (main.nodes.length - 1) * stepX + xLeft
        const finalY = canvas.height - paddingY - stepY * main.nodes[main.nodes.length - 1].percent;
        drawCircle(ctx, finalX, finalY)

        canvasRef.current.addEventListener('mousemove', e => checkHover(e.clientX))
    }, []);


    function defineBreakPoints(): void {
        for (let i = 0; i < main.nodes.length; i++) {
            breakPoints.push({
                x0: (i + 1) * stepX - xLeft,
                x1: (i + 2) * stepX - xLeft,
                y: (canvasRef.current.height - paddingY - stepY * main.nodes[i].percent),
                node: main.nodes[i],
                index: i
            })
        }
    }


    function drawScales(): void {
        const canvas = canvasRef.current
        const ctx = getContext()
        const scalesStepY = (canvas.height - paddingY * 2) / stepsY;

        for (let i = 0; i <= stepsY; i++) {
            ctx.setLineDash([20, 15])
            ctx.beginPath();
            ctx.moveTo(0, scalesStepY * i + paddingY);
            ctx.lineTo(canvas.width - xLeft - xRight, scalesStepY * i + paddingY);
            ctx.strokeStyle = '#ccc';
            ctx.lineWidth = 1;
            ctx.stroke();
            ctx.font = '30px Arial';
            ctx.fillStyle = '#777';
            ctx.fillText(scales[i], canvas.width - xLeft - xRight + 5, scalesStepY * i + paddingY + 8)
            ctx.setLineDash([])
        }
    }


    function drawLine(nodes: ChartNode[], color: string, i0: number, i1: number) {
        const canvas = canvasRef.current
        const ctx = getContext()

        const x0 = i0 * stepX + xLeft;
        const y0 = (canvas.height - paddingY - stepY * nodes[i0].percent);
        const x1 = (i1) * stepX + xLeft;
        const y1 = (canvas.height - paddingY - stepY * nodes[i1].percent);

        ctx.beginPath();
        ctx.moveTo(x0, y0);
        ctx.lineTo(x1, y1);

        ctx.strokeStyle = color;
        ctx.lineWidth = 5;
        ctx.stroke();

        ctx.lineTo(x1, canvas.height - paddingY);
        ctx.lineTo(x0, canvas.height - paddingY);
        ctx.lineTo(x0, y0);
        ctx.fillStyle = color + '11';
        ctx.fill();
    }


    function drawCircle(ctx, x: number, y: number): void {
        ctx.strokeStyle = '#D33F49'
        ctx.lineWidth = 5

        // outer circle
        ctx.beginPath()
        ctx.moveTo(x, y)
        ctx.arc(x, y, 10, 0, 2 * Math.PI)
        ctx.stroke();

        // inner circle
        ctx.beginPath()
        ctx.arc(x, y, 5, 0, 2 * Math.PI)
        ctx.strokeStyle = 'white'
        ctx.stroke();
        ctx.fillStyle = 'white';
        ctx.fill()
    }


    function checkHover(clientX: number) {
        const canvas = canvasRef.current;
        const tempCtx = tempCanvasRef.current.getContext('2d')

        const rect = canvas.getBoundingClientRect();
        const scaleX = canvas.width / rect.width;

        const x = (clientX - rect.left) * scaleX;

        for (let i = 0; i < breakPoints.length; i++) {
            if (breakPoints[i].x0 < x && x < breakPoints[i].x1) {
                setCurrentBreakPoint(breakPoints[i])
                tempCtx.clearRect(0, 0, 1000, 500)

                tempCtx.beginPath()
                tempCtx.strokeStyle = '#bbb'
                tempCtx.lineWidth = 1
                tempCtx.moveTo(breakPoints[i].x0, paddingY)
                tempCtx.lineTo(breakPoints[i].x0, canvas.height - paddingY)
                tempCtx.stroke()

                drawCircle(tempCtx, breakPoints[i].x0, breakPoints[i].y)

                return
            }
        }
    }


    return (
        <div className="transaction-chart">
            <Flow flow={flow}/>
            {currentBreakPoint != null &&
                <div className="transaction-chart__node-data">
                    <p>{currentBreakPoint.node.date}: <span
                        className="main">{currentBreakPoint.node.value.toFixed(2)}</span></p>
                    <p>Same period: <span
                        className="compared">{compared.nodes[currentBreakPoint.index].value.toFixed(2)}</span></p>
                </div>
            }

            <div className="transaction-chart__chart-container">
                <canvas className="transaction-chart__chart" ref={canvasRef} width={1000} height={500}/>
                <canvas className="transaction-chart__chart temp" ref={tempCanvasRef} width={1000} height={500}/>
            </div>
        </div>
    );
}
