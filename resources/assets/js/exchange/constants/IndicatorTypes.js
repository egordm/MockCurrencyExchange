import { ema, sma, wma, tma, bollingerBand, sar } from "react-stockcharts/lib/indicator";

export const EMA = {label: "Moving Average (Exponential)", value: "EMA", calculator: ema};
export const SMA = {label: "Moving Average (Simple)", value: "SMA", calculator: sma};
export const WMA = {label: "Moving Average (Weighted)", value: "WMA", calculator: wma};
export const TMA = {label: "Moving Average (Triangular)", value: "TMA", calculator: tma};
export const BOLL = {label: "Bollinger Band", value: "BOLL", calculator: bollingerBand};
export const SAR = {label: "SAR", value: "SAR", calculator: sar};

export const Indicators = [EMA, SMA, WMA, TMA, BOLL, SAR];